<?php

use App\Http\Controllers\Admin\FrontendContentController;
use App\Http\Controllers\Frontend\BookOrderController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseRegistrationController;
use App\Http\Controllers\Frontend\CourseReviewController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================

// Home Page
Route::get('/', [FrontendController::class, 'index'])->name('home');

// Content Pages
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontendController::class, 'showCourse'])->name('courses.show');
Route::get('/books', [FrontendController::class, 'books'])->name('books.index');
Route::get('/books/{book:slug}', [FrontendController::class, 'showBook'])->name('books.show');
Route::get('/video-blogs', [FrontendController::class, 'videoBlogs'])->name('video_blogs.index');
Route::get('/video-blogs/{videoBlog:slug}', [FrontendController::class, 'showVideoBlog'])->name('video_blogs.show');
Route::get('/galleries', [FrontendController::class, 'galleries'])->name('galleries.index');

// Static Pages
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Language Switching
Route::get('/language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch');

// ============================================
// COURSE ENROLLMENT ROUTES
// ============================================
Route::get('/courses/{course:slug}/enroll', [CourseRegistrationController::class, 'create'])
    ->name('courses.enroll');
Route::post('/courses/{course:slug}/enroll', [CourseRegistrationController::class, 'store'])
    ->name('courses.enroll.store');
Route::post('/courses/{course:slug}/reviews', [CourseReviewController::class, 'store'])
    ->middleware('auth')
    ->name('courses.reviews.store');

// ============================================
// BOOK ORDER ROUTES
// ============================================
Route::get('/books/{book:slug}/checkout', [BookOrderController::class, 'create'])
    ->name('books.checkout');
Route::post('/books/{book:slug}/checkout', [BookOrderController::class, 'store'])
    ->name('books.checkout.store');

// ============================================
// LANDING PAGE ROUTES
// ============================================
Route::get('/lp/{slug}', [LandingPageController::class, 'show'])
    ->name('landing-page.show');
Route::post('/lp/{slug}/order', [BookOrderController::class, 'storeFromLandingPage'])
    ->name('landing-page.order.store');
Route::post('/lp/{slug}/course-register', [CourseRegistrationController::class, 'storeFromLandingPage'])
    ->name('landing-page.course.store');

// ============================================
// AUTHENTICATED ROUTES
// ============================================
Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [FrontendController::class, 'dashboard'])
        ->middleware('verified')
        ->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Frontend CMS (Admin Only - handled by middleware in controller)
    Route::get('/admin/frontend-content', [FrontendContentController::class, 'index'])
        ->name('admin.frontend-content.index');
    Route::post('/admin/frontend-content', [FrontendContentController::class, 'update'])
        ->name('admin.frontend-content.update');

    // Teachers Management
    Route::resource('admin/teachers', \App\Http\Controllers\Admin\TeacherController::class, ['as' => 'admin']);
});

require __DIR__ . '/auth.php';
