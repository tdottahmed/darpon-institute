<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookOrderController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseRegistrationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoBlogController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // User Management
    Route::resource('users', UserController::class);

    // Course Management
    Route::resource('courses', CourseController::class);

    // Book Management
    Route::resource('books', BookController::class);
    Route::get('books/{book}/json', [BookController::class, 'json'])->name('books.json');

    // Video Blog Management
    Route::resource('video-blogs', VideoBlogController::class);

    // Shipping Methods
    Route::resource('shipping-methods', ShippingController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);

    // Gallery Management
    Route::resource('galleries', GalleryController::class)->except(['show', 'edit']);

    Route::resource('book-orders', BookOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::get('book-orders/{bookOrder}/invoice', [BookOrderController::class, 'invoice'])->name('book-orders.invoice');
    Route::post('book-orders/{bookOrder}/check-fraud', [BookOrderController::class, 'checkFraud'])->name('book-orders.check-fraud');

    // Course Registrations - Installments route must come BEFORE resource route
    Route::get('course-registrations/installments', [CourseRegistrationController::class, 'installments'])->name('course-registrations.installments');

    Route::resource('course-registrations', CourseRegistrationController::class)->only(['index', 'create', 'store', 'show', 'update', 'destroy']);
    Route::get('course-registrations/{courseRegistration}/invoice', [CourseRegistrationController::class, 'invoice'])->name('course-registrations.invoice');
    Route::post('course-registrations/{courseRegistration}/send-invoice', [CourseRegistrationController::class, 'sendInvoice'])->name('course-registrations.send-invoice');
    Route::post('course-registrations/{courseRegistration}/installments/{installment}', [CourseRegistrationController::class, 'updateInstallment'])->name('course-registrations.installments.update')->scopeBindings();

    // Payment Gateways
    Route::resource('payment-gateways', PaymentGatewayController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Landing Pages
    Route::resource('landing-pages', LandingPageController::class);
    Route::post('landing-pages/store-partial', [LandingPageController::class, 'storePartial'])->name('landing-pages.store-partial');
    Route::put('landing-pages/{landing_page}/update-partial', [LandingPageController::class, 'updatePartial'])->name('landing-pages.update-partial');
});
