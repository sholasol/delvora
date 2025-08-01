<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');
Route::get('/services', [FrontController::class, 'services'])->name('front.services');
Route::get('/gallery', [FrontController::class, 'gallery'])->name('front.gallery');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::get('/book', [FrontController::class, 'book'])->name('front.book');
Route::get('/confirmation', [FrontController::class, 'confirmation'])->name('front.confirmation');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
    Route::get('/staff', [AdminController::class, 'staff'])->name('staff');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
