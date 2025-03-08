<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Store Routes
|--------------------------------------------------------------------------
|
| Here you can register routes that will be accessible only within
| specific stores. These routes are loaded by the TenancyServiceProvider
| using the Laravel Tenancy package behind the scenes.
|
| Routes defined here will automatically have these middleware applied:
| - InitializeTenancyByDomain
| - PreventAccessFromCentralDomains
| - web
|
*/

Route::get('/', function () {
    return 'This is your store: ' . tenant('id');
});

// Example store routes
Route::get('/products', function () {
    return 'Products for store: ' . tenant('id');
});

Route::get('/cart', function () {
    return 'Shopping cart for store: ' . tenant('id');
});

Route::get('/checkout', function () {
    return 'Checkout for store: ' . tenant('id');
});
