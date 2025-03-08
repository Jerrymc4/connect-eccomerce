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
    // Registration
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'show'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

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
    
    // Home route after authentication
    Route::get('/home', function () {
        // Redirect based on user type
        $user = \Illuminate\Support\Facades\Auth::user();
        
        // Check user type by property instead of method
        if ($user->user_type === \App\Models\User::TYPE_ADMIN) {
            // Admin dashboard
            return view('admin.dashboard');
        } elseif ($user->user_type === \App\Models\User::TYPE_STORE_OWNER) {
            // If they have only one store, redirect to it
            $stores = $user->ownedStores;
            
            if ($stores->count() === 0) {
                // No stores yet, show the dashboard with option to create store
                return view('admin.dashboard');
            } elseif ($stores->count() === 1) {
                // Get the store URL if available
                $store = $stores->first();
                $domain = $store->domains->first();
                
                if ($domain) {
                    return redirect()->away("https://{$domain->domain}");
                }
            }
            
            // Otherwise, show the dashboard with stores list
            return view('admin.dashboard');
        }
        
        return view('admin.dashboard');
    })->name('home');
});

// Google Authentication
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Store management routes (formerly tenant management)
Route::prefix('stores')->group(function () {
    // List all stores
    Route::get('/', function () {
        $stores = Store::getAllStores();
        return view('stores.index', compact('stores'));
    })->name('stores.index');
    
    // Create a new store (form)
    Route::get('/create', function () {
        return view('stores.create');
    })->name('stores.create');
    
    // Create a new store (action)
    Route::post('/', function () {
        $validated = request()->validate([
            'id' => 'required|string|max:255|unique:tenants',
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:domains,domain',
        ]);
        
        $store = Store::createStore(
            $validated['id'], 
            $validated['name'],
            $validated['domain']
        );
        
        return redirect()->route('stores.index')
            ->with('success', 'Store created successfully!');
    })->name('stores.store');
});
