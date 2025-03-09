<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MultiStepRegistrationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

// For debugging purposes
Route::get('/auth-debug', function() {
    return 'Auth routes are loaded!';
});

// Guest routes
Route::middleware('guest')->group(function () {
    // Registration Steps
    Route::get('/register', [MultiStepRegistrationController::class, 'showPlans'])->name('register');
    Route::post('/register/plan', [MultiStepRegistrationController::class, 'selectPlan'])->name('register.plan.select');
    
    Route::get('/register/account', [MultiStepRegistrationController::class, 'showAccount'])->name('register.account');
    Route::post('/register/account', [MultiStepRegistrationController::class, 'createAccount'])->name('register.account.create');
    
    Route::get('/register/store', [MultiStepRegistrationController::class, 'showStore'])->name('register.store');
    Route::post('/register/store', [MultiStepRegistrationController::class, 'createStore'])->name('register.store.create');

    // Login
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Google Authentication
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']); 