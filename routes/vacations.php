<?php

use App\Http\Controllers\VacationsController;
use Illuminate\Support\Facades\Route;
use App\Models\Vacation;
use App\Http\Controllers\BookingController;


Route::middleware('auth')->group(function () {
    // Lijst met vakanties
    Route::get('/', [VacationsController::class, 'index'])->name('vacations.index');

    // Formulier om een nieuwe vakantie aan te maken
    Route::get('/create', [VacationsController::class, 'create'])->name('vacation.create');

    // Opslaan van een nieuwe vakantie
    Route::post('/', [VacationsController::class, 'store'])->name('vacation.store');

    // Details van een specifieke vakantie
    Route::get('/{id}', [VacationsController::class, 'show'])->name('vacation.show');

    Route::get('/{vacation}/book', [BookingController::class, 'create'])->name('bookings.create');

    Route::post('/{vacation}/book', [BookingController::class, 'store'])->name('bookings.store');



});
