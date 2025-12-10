<?php

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontendController::class, 'showCourse'])->name('courses.show');
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

require __DIR__ . '/auth.php';
