<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);

    // Course Management
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);

    // Book Management
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class);

    // Video Blog Management
    Route::resource('video-blogs', \App\Http\Controllers\Admin\VideoBlogController::class);

    // Shipping Methods
    Route::resource('shipping-methods', \App\Http\Controllers\Admin\ShippingController::class);

    // Testimonials
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);

    // Gallery Management
    Route::resource('galleries', \App\Http\Controllers\Admin\GalleryController::class)->except(['show', 'edit']);

    Route::resource('book-orders', \App\Http\Controllers\Admin\BookOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('course-registrations', \App\Http\Controllers\Admin\CourseRegistrationController::class)->only(['index', 'show', 'update', 'destroy']);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
