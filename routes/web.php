<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HRAuthController;
use App\Http\Controllers\HRDashboardController;
use App\Http\Controllers\HRReportsController;
use App\Http\Controllers\CandidateController;

// Public candidate routes (for job application, etc.)
Route::get('/', [CandidateController::class, 'create'])->name('candidate.apply');
Route::post('/apply', [CandidateController::class, 'store'])->name('candidate.store');
Route::get('/thank-you', function () {
    return view('candidate.thankyou');
})->name('candidate.thankyou');

// HR Authentication Routes
Route::prefix('hr')->group(function () {

    // Registration Routes
    Route::get('/register', [HRAuthController::class, 'showRegisterForm'])->name('hr.register');
    Route::post('/register', [HRAuthController::class, 'register'])->name('hr.register.submit');

    // Login Routes
    Route::get('/login', [HRAuthController::class, 'showLoginForm'])->name('hr.login');
    Route::post('/login', [HRAuthController::class, 'login'])->name('hr.login.submit');

    // Logout Route
    Route::post('/logout', [HRAuthController::class, 'logout'])->name('hr.logout');

    // Protected HR Routes (requires login)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('hr.dashboard');
        Route::get('/applications', [CandidateController::class, 'index'])->name('hr.applications');
        Route::get('/application/{id}', [CandidateController::class, 'show'])->name('hr.application.show');
        Route::post('/application/{id}/update', [CandidateController::class, 'update'])->name('hr.application.update');
        Route::get('/reports', [HRReportsController::class, 'index'])->name('hr.reports');
    });
});
