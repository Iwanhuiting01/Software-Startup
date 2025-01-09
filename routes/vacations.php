<?php

use Illuminate\Support\Facades\Route;
use App\Models\Vacation;

// Lijst met vakanties
Route::get('/', function () {
    $vacations = Vacation::all(); // Haal vakanties op uit de database
    return view('book-vacations', compact('vacations'));
})->name('vacations.index');

// Formulier om een nieuwe vakantie aan te maken
Route::get('/create', function() {
    return view('create-vacation');
})->name('vacation.create');

// Opslaan van een nieuwe vakantie
Route::post('/', function(Illuminate\Http\Request $request) {
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'group_size' => 'required|integer|min:1',
    ]);

    // Sla de vakantie op in de database
    Vacation::create($data);

    // Redirect naar de vakantielijst
    return redirect()->route('vacations.index');
})->name('vacation.store');

// Details van een specifieke vakantie
Route::get('/{id}', function ($id) {
    $vacation = Vacation::findOrFail($id); // Zoek vakantie op ID
    return view('show-vacation', compact('vacation'));
})->name('vacations.show');