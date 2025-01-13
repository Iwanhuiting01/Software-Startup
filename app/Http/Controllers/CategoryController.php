<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Show the form to create a new category
    public function create()
    {
        return view('create-category');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Save the category in the database
        Category::create($data);

        // Redirect to a category list or back to the form
        return redirect()->route('category.manage')->with('success', 'De categorie is succesvol aangemaakt!');
    }

    // Show the category management page
    public function manage()
    {
        $categories = Category::all();
        return view('category-management', compact('categories'));
    }

    // Delete a category
    public function delete($id)
    {
        $category = Category::findOrFail($id);

        // Check if the category can be deleted
        if ($category->vacations()->exists()) {
            return redirect()->route('category.manage')->withErrors('De categorie kan niet worden verwijderd omdat er vakanties aan de categorie zijn gebonden.');
        }

        $category->delete();
        return redirect()->route('category.manage')->with('success', 'Categorie succesvol verwijderd!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('edit-category', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update($data);

        return redirect()->route('category.manage')->with('success', 'Category succesvol geupdate!');
    }

}
