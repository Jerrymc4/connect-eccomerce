<?php

use Illuminate\Support\Facades\Route;
use App\Models\Store;
use Stancl\Tenancy\Database\Models\Domain;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Multi-Step Registration
    Route::get('/register', function() {
        return redirect()->route('register.plans');
    })->name('register');
    
    Route::get('/register/plans', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'showPlans'])->name('register.plans');
    Route::post('/register/plans', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'selectPlan'])->name('register.select-plan');
    
    Route::get('/register/account', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'showAccountForm'])->name('register.account');
    Route::post('/register/account', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'createAccount'])->name('register.create-account');
    
    Route::get('/register/billing', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'showBilling'])->name('register.billing');
    Route::post('/register/billing', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'processBilling'])->name('register.process-billing');
    
    Route::get('/register/store', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'showStoreForm'])->name('register.store');
    Route::post('/register/store', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'createStore'])->name('register.create-store');

    // Login
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

    // Password Reset
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    
    // Onboarding Routes
    Route::get('/store/onboarding', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'showOnboarding'])->name('store.onboarding');
    Route::post('/store/onboarding/complete', [App\Http\Controllers\Auth\MultiStepRegistrationController::class, 'completeOnboarding'])->name('store.onboarding.complete');
    
    // Home route after authentication
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Google Authentication
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Store management routes (formerly tenant management)
Route::prefix('stores')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Store\StoreController::class, 'index'])->name('stores.index');
});

// Store Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('{store}')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Store\DashboardController::class, 'index'])->name('store.dashboard');
        Route::get('/settings', [App\Http\Controllers\Store\SettingsController::class, 'index'])->name('store.settings');
        
        // Products
        Route::resource('products', App\Http\Controllers\Store\ProductController::class)->names('store.products');
        
        // Orders
        Route::resource('orders', App\Http\Controllers\Store\OrderController::class)->names('store.orders');
        
        // Customers
        Route::resource('customers', App\Http\Controllers\Store\CustomerController::class)->names('store.customers');
        
        // Reports
        Route::get('/reports', [App\Http\Controllers\Store\ReportController::class, 'index'])->name('store.reports');
    });
});
