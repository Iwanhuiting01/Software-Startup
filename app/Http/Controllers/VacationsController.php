<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Vacation;

class VacationsController extends Controller
{
    // Display a list of vacations
    public function index()
    {
        $vacations = Vacation::all()->reverse(); // Haal vakanties op uit de database
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
