<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontendController::class, 'showCourse'])->name('courses.show');
Route::get('/books', [FrontendController::class, 'books'])->name('books.index');
Route::get('/books/{book:slug}', [FrontendController::class, 'showBook'])->name('books.show');
Route::get('/video-blogs', [FrontendController::class, 'videoBlogs'])->name('video_blogs.index');
Route::get('/video-blogs/{videoBlog:slug}', [FrontendController::class, 'showVideoBlog'])->name('video_blogs.show');
Route::get('/dashboard', [App\Http\Controllers\Frontend\FrontendController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])
    ->name('language.switch');

Route::get('/courses/{course:slug}/enroll', [\App\Http\Controllers\Frontend\CourseRegistrationController::class, 'create'])->name('courses.enroll');
Route::post('/courses/{course:slug}/enroll', [\App\Http\Controllers\Frontend\CourseRegistrationController::class, 'store'])->name('courses.enroll.store');

Route::get('/books/{book:slug}/checkout', [\App\Http\Controllers\Frontend\BookOrderController::class, 'create'])->name('books.checkout');
Route::post('/books/{book:slug}/checkout', [\App\Http\Controllers\Frontend\BookOrderController::class, 'store'])->name('books.checkout.store');

require __DIR__ . '/auth.php';
