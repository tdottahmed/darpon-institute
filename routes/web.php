<?php

use App\Http\Controllers\Admin\FrontendContentController;
use App\Http\Controllers\Admin\FreeClassLeadController as AdminFreeClassLeadController;
use App\Http\Controllers\Frontend\BookOrderController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CourseRegistrationController;
use App\Http\Controllers\Frontend\CourseReviewController;
use App\Http\Controllers\Frontend\FreeClassLeadController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\LandingPageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// ============================================
// PUBLIC ROUTES
// ============================================

// Search API
Route::get('/api/search', [SearchController::class, 'search'])->name('search.api');

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
Route::get('/instructors', [FrontendController::class, 'instructors'])->name('instructors.index');
Route::get('/instructors/{instructor}', [FrontendController::class, 'showInstructor'])->name('instructors.show');

// Static Pages
Route::get('/why-choose-us', [FrontendController::class, 'whyChooseUs'])->name('why-choose-us');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Free Class Lead
Route::post('/free-class-leads', [FreeClassLeadController::class, 'store'])->name('free-class-leads.store');

// Language Switching
Route::get('/language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch');

// RSS Feed
Route::feeds();

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
    Route::post('/admin/frontend-content/{id}', [FrontendContentController::class, 'destroy'])->name('admin.frontend-content.destroy');

    // Teachers Management
    Route::resource('admin/teachers', \App\Http\Controllers\Admin\TeacherController::class, ['as' => 'admin']);

    // Custom Pages Management
    Route::resource('admin/custom-pages', CustomPageController::class, ['as' => 'admin']);

    // About Page Management
    Route::group(['prefix' => 'admin/about', 'as' => 'admin.about.'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('index');
        Route::post('/update', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('update');
    });

    // Free Class Leads
    Route::get('/admin/free-class-leads', [AdminFreeClassLeadController::class, 'index'])->name('admin.free-class-leads.index');
    Route::patch('/admin/free-class-leads/{lead}/status', [AdminFreeClassLeadController::class, 'updateStatus'])->name('admin.free-class-leads.status');
    Route::patch('/admin/free-class-leads/{lead}/notes', [AdminFreeClassLeadController::class, 'updateNotes'])->name('admin.free-class-leads.notes');
    Route::delete('/admin/free-class-leads/{lead}', [AdminFreeClassLeadController::class, 'destroy'])->name('admin.free-class-leads.destroy');
});

// We need here route for artisan migrtae and seed
Route::group(['prefix' => '', 'as' => ''], function () {
    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return redirect()->back()->with('success', 'Migrated successfully');
    })->name('migrate');
    Route::get('/seed', function () {
        Artisan::call('db:seed --class=FrontendContentSeeder');
        return redirect()->back()->with('success', 'Seeded successfully');
    })->name('seed');
    Route::get('/seed-whychose', function () {
        Artisan::call('db:seed --class=WhyChooseUsSeeder');
        return redirect()->back()->with('success', 'Seeded successfully');
    })->name('seed-whychose');
    Route::get('optimize', function () {
        Artisan::call('optimize');
        return redirect()->back()->with('success', 'Optimized successfully');
    })->name('optimize');
    Route::get('optimize-clear', function () {
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'Optimized clear successfully');
    })->name('optimize-clear');
    Route::get('storage-link', function () {
        Artisan::call('storage:link');
        return redirect()->back()->with('success', 'Storage linked successfully');
    })->name('storage-link');
});
require __DIR__ . '/auth.php';
