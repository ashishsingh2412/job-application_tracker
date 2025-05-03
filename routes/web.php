<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\HomeController;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Auth::routes();

// Home route (for backward compatibility, redirects to dashboard)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Job Applications routes
    Route::resource('job-applications', JobApplicationController::class);

    // Reminders routes
    Route::resource('reminders', ReminderController::class);
    Route::patch('/reminders/{reminder}/toggle-complete', [ReminderController::class, 'toggleComplete'])
        ->name('reminders.toggle-complete');
});
