<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application.
| These routes are loaded by the RouteServiceProvider and use the 'web'
| middleware group with the 'auth' middleware.
|
*/

Route::middleware(['auth', 'web'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Stores
    Route::resource('stores', StoreController::class);
    
    // Users
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    Route::get('/users/create', function () {
        return view('admin.users.create');
    })->name('users.create');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
}); 