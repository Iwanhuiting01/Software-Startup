<?php

use Illuminate\Support\Facades\Route;

// Lijst met vakanties
Route::get('/', function () {
    $vacations = [
        [
            'title' => 'Zonvakantie naar Spanje',
            'description' => 'Geniet van de zon en de zee in Spanje.',
            'group_size' => 15,
            'current_participants' => 4,
        ],
        [
            'title' => 'Skiën in Oostenrijk',
            'description' => 'Prachtige pistes en après-ski plezier.',
            'group_size' => 20,
            'current_participants' => 6,
        ],
    ];
    return view('book-vacations', compact('vacations'));
})->name('vacations.index');

// Formulier om een nieuwe vakantie aan te maken
Route::get('/create', function() {
    return view('create-vacation');
})->name('vacation.create');

// Opslaan van een nieuwe vakantie
Route::post('/', function(Illuminate\Http\request $request) {
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'group_size' => 'required|integer|min:1',
    ]);
    // Opslaan in database
    //
})->name('vacation.store');

// Details van een specifieke vakantie
Route::get('/{id}', function ($id) {
    $vacation = [
        'id' => $id,
        'title' => 'Voorbeeldvakantie',
        'description' => 'Beschrijving van de voorbeeldvakantie.',
        'group_size' => 10,
        'current_participants' => 4,
    ];
    return view('show-vacation', compact('vacation'));
})->name('vacations.show');