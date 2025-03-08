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

// Central domain routes
Route::get('/', function () {
    return view('welcome');
});

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
