<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

/*
|--------------------------------------------------------------------------
| Store Routes
|--------------------------------------------------------------------------
|
| Here is where you can register store-specific routes for your application.
| These routes are loaded by the RouteServiceProvider and use the 'store'
| middleware group.
|
*/

Route::middleware(['store', 'auth:store'])->group(function () {
    
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('store.dashboard');
    })->name('store.dashboard');
    
    // Staff management routes
    Route::resource('staff', StaffController::class);
    Route::post('staff/{staff}/promote', [StaffController::class, 'promoteToAdmin'])
        ->name('staff.promote');
        
    // Add other store-specific routes here
});

// Guest routes (for store domain but not authenticated)
Route::middleware(['store'])->group(function () {
    Route::get('/', function () {
        return view('store.welcome');
    })->name('store.welcome');
}); 