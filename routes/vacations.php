<?php

use App\Http\Controllers\VacationsController;
use Illuminate\Support\Facades\Route;
use App\Models\Vacation;


Route::middleware('auth')->group(function () {
    // Lijst met vakanties
    Route::get('/', [VacationsController::class, 'index'])->name('vacations.index');

    // Formulier om een nieuwe vakantie aan te maken
    Route::get('/create', [VacationsController::class, 'create'])->name('vacation.create');

    // Opslaan van een nieuwe vakantie
    Route::post('/', [VacationsController::class, 'store'])->name('vacation.store');

    // Details van een specifieke vakantie
    Route::get('/{id}', [VacationsController::class, 'show'])->name('vacation.show');

});
