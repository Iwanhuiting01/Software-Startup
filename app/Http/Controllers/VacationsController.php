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
    $query = Vacation::query();

    // Zoekterm filteren
    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%')
              ->orWhere('destination', 'like', '%' . $request->search . '%');
    }

    // Filteren op bestemming
    if ($request->has('destination') && $request->destination != '') {
        $query->where('destination', $request->destination);
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

    return view('book-vacations', compact('vacations'));
}


    // Show the form to create a new vacation
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('create-vacation', compact('categories'));
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
}
