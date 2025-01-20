<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\homepage;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Vacation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [homepage::class, 'Homepage'])->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('category.store');

    Route::get('/categories', [CategoryController::class, 'manage'])->name('category.manage');

    Route::post('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

    Route::get('/bookings/manage', [BookingController::class, 'manage'])->name('bookings.manage');

    Route::get('/bookings/{booking}/pay', [BookingController::class, 'pay'])->name('bookings.pay');

    Route::post('/bookings/{booking}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('bookings.confirm-payment');
});

require __DIR__.'/auth.php';
