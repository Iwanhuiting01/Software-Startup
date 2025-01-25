<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Vacation;

class VacationsController extends Controller
{
    // Display a list of vacations
    public function index(Request $request)
    {
        $destinations = Vacation::select('title')->distinct()->where('is_closed', false)->orderByDesc('created_at')->get();

        $categories = Category::all();

        $query = Vacation::query()->where('is_closed', false)->orderByDesc('created_at');

        // Zoekterm filteren
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('destination', 'like', '%' . $request->search . '%');
        }

        // Filter on category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category); // Specify the table name
            });
        }

        // Filteren op bestemming
        if ($request->has('destination') && $request->destination != '') {
            $query->where('title', $request->destination);
        }

        // Filteren op groepsgrootte
        if ($request->has('max_group_size') && $request->max_group_size != '') {
            $query->where('max_group_size', '>=', $request->max_group_size);
        }

        // Filteren op prijs
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Filteren op datum
        if ($request->has('start_date') && $request->start_date != '') {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->where('end_date', '<=', $request->end_date);
        }




        $vacations = $query->get();

        return view('book-vacations', compact('vacations', 'destinations', 'categories'));
    }


    // Show the form to create a new vacation
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('create-vacation', compact('categories'));
    }

    // Show the form to create a new vacation
    public function manage()
    {
        // Fetch vacations created by the currently logged-in user
        $vacations = Vacation::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('vacations.manage', compact('vacations'));
    }

    // Show the form to create a new vacation
    public function manageView($id)
    {
        // Fetch vacation created by the currently logged-in user
        $vacation = Vacation::with('categories', 'bookings')->findOrFail($id);

        return view('vacations.manageOne', compact('vacation'));
    }

    public function close($id, $overview = false)
    {
        $vacation = Vacation::findOrFail($id);

        if ($vacation->user_id !== auth()->id()) {
            abort(403, 'Je hebt geen toestemming om deze actie uit te voeren.');
        }

        $vacation->is_closed = true;
        $vacation->save();

        if ($overview) {
            return redirect()->route('vacations.manage')->with('success', 'Vakantie succesvol gesloten.');
        }
        return redirect()->route('vacation.manage', $id)->with('success', 'Vakantie succesvol gesloten.');
    }

    public function reopen($id, $overview = false)
    {
        $vacation = Vacation::findOrFail($id);

        if ($vacation->user_id !== auth()->id()) {
            abort(403, 'Je hebt geen toestemming om deze actie uit te voeren.');
        }

        $vacation->is_closed = false;
        $vacation->save();

        if ($overview) {
            return redirect()->route('vacations.manage')->with('success', 'Vakantie succesvol geopend.');
        }
        return redirect()->route('vacation.manage', $id)->with('success', 'Vakantie succesvol geopend.');
    }

    // Store a new vacation in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'max_group_size' => 'required|integer|min:1',
            'min_group_size' => 'required|integer|min:1|lte:max_group_size',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->storeAs('images', time() . '_' . $image->getClientOriginalName(), 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        $data['user_id'] = auth()->id();
        $vacation = Vacation::create($data);

        // Attach categories to the vacation
        if ($request->has('categories')) {
            $vacation->categories()->sync(array_map('intval', $request->categories));
        }

        return redirect()->route('vacations.index');
    }

    // Display details of a specific vacation
    public function show($id)
    {
        $vacation = Vacation::findOrFail($id); // Zoek vakantie op ID
        return view('show-vacation', compact('vacation'));
    }

    // Display details of a specific vacation
    public function edit($id, $overview = false)
    {
        $categories = Category::all();
        $vacation = Vacation::findOrFail($id); // Zoek vakantie op ID
        return view('vacations.edit', compact('vacation', 'categories', 'overview'));
    }

    public function update(Request $request, $id, $overview = false)
    {
        $vacation = Vacation::findOrFail($id);

        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'min_group_size' => 'required|integer|min:1',
            'max_group_size' => 'required|integer|min:1|gte:min_group_size',
            'price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
        ]);

        // Update vacation details
        $vacation->update($validated);

        // Update categories if provided
        if ($request->has('categories')) {
            $vacation->categories()->sync($request->categories);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vacation_images', 'public');
            $vacation->image = $path;
            $vacation->save();
        }

        if ($overview) {
            return redirect()->route('vacations.manage')->with('success', 'Vakantie succesvol bijgewerkt!');
        }
        return redirect()->route('vacation.manage', $id)->with('success', 'Vakantie succesvol bijgewerkt!');
    }
}
