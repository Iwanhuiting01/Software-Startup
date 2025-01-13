<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;

class VacationsController extends Controller
{
    // Display a list of vacations
    public function index()
    {
        $vacations = Vacation::all(); // Haal vakanties op uit de database
        return view('book-vacations', compact('vacations'));
    }

    // Show the form to create a new vacation
    public function create()
    {
        return view('create-vacation');
    }

    // Store a new vacation in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'group_size' => 'required|integer|min:1',
        ]);

        // Sla de vakantie op in de database
        Vacation::create($data);

        // Redirect naar de vakantielijst
        return redirect()->route('vacations.index');
    }

    // Display details of a specific vacation
    public function show($id)
    {
        $vacation = Vacation::findOrFail($id); // Zoek vakantie op ID
        return view('show-vacation', compact('vacation'));
    }
}
