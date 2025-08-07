<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;

// Frontend Routes
Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/about', [FrontController::class, 'about'])->name('front.about');
Route::get('/services', [FrontController::class, 'services'])->name('front.services');
Route::get('/services/{id}', [FrontController::class, 'serviceDetails'])->name('front.service-details');
Route::get('/gallery', [FrontController::class, 'gallery'])->name('front.gallery');
Route::get('/contact', [FrontController::class, 'contact'])->name('front.contact');
Route::post('/contact', [FrontController::class, 'contactSubmit'])->name('front.contact.submit');
Route::get('/book', [FrontController::class, 'book'])->name('front.book');
Route::get('/confirmation/{reference}', [FrontController::class, 'confirmation'])->name('front.confirmation');
Route::get('/track/{reference}', [FrontController::class, 'track'])->name('front.track');
Route::get('/search/services', [FrontController::class, 'searchServices'])->name('front.search.services');
Route::post('/contactSubmit', [FrontController::class, 'contactSubmit'])->name('contactSubmit');

// Booking Routes
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::post('/bookings/{reference}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

// Admin Dashboard
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Admin Routes
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::patch('/admin/bookings/{id}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
    
    // Customer Routes
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/admin/customers/{id}', [CustomerController::class, 'show'])->name('customers.details');
    Route::patch('/admin/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/admin/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/admin/customers/export/csv', [CustomerController::class, 'export'])->name('customers.export');
    
    // Staff Routes
    Route::get('/admin/staff', [AdminController::class, 'staff'])->name('staff');
    Route::post('/admin/staff', [AdminController::class, 'storeStaff'])->name('staff.store');
    Route::patch('/admin/staff/{id}', [AdminController::class, 'updateStaff'])->name('staff.update');
    
    // Gallery Routes
    Route::get('/admin/gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::post('/admin/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/admin/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::patch('/admin/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/admin/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::patch('/admin/gallery/{id}/feature', [GalleryController::class, 'toggleFeatured'])->name('gallery.toggle-featured');
    Route::patch('/admin/gallery/sort-order', [GalleryController::class, 'updateSortOrder'])->name('gallery.sort-order');
    Route::post('/admin/gallery/bulk-action', [GalleryController::class, 'bulkAction'])->name('gallery.bulk-action');
    
    // Services Routes
    Route::get('/admin/services', [ServicesController::class, 'index'])->name('services');
    Route::post('/admin/services', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/admin/services/{id}', [ServicesController::class, 'show'])->name('services.show');
    Route::patch('/admin/services/{id}', [ServicesController::class, 'update'])->name('services.update');
    Route::delete('/admin/services/{id}', [ServicesController::class, 'destroy'])->name('services.destroy');
    Route::patch('/admin/services/{id}/feature', [ServicesController::class, 'toggleFeatured'])->name('services.toggle-featured');
    Route::patch('/admin/services/sort-order', [ServicesController::class, 'updateSortOrder'])->name('services.sort-order');
    
    // Settings Route
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/admin/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('dashboard.stats');
    Route::get('/admin/bookings/export/csv', [AdminController::class, 'exportBookings'])->name('bookings.export');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
