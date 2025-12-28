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
    Route::resource('course-registrations', \App\Http\Controllers\Admin\CourseRegistrationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
    Route::get('course-registrations/{courseRegistration}/invoice', [\App\Http\Controllers\Admin\CourseRegistrationController::class, 'invoice'])->name('course-registrations.invoice');
    Route::post('course-registrations/{courseRegistration}/send-invoice', [\App\Http\Controllers\Admin\CourseRegistrationController::class, 'sendInvoice'])->name('course-registrations.send-invoice');
    Route::post('course-registrations/{courseRegistration}/installments/{installment}', [\App\Http\Controllers\Admin\CourseRegistrationController::class, 'updateInstallment'])->name('course-registrations.installments.update')->scopeBindings();

    // Payment Gateways
    Route::resource('payment-gateways', \App\Http\Controllers\Admin\PaymentGatewayController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
