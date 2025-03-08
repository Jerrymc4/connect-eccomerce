<?php

namespace App\Providers;

use App\Models\Store;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\DatabaseConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the TenantWithDatabase contract to our Store model
        $this->app->bind(TenantWithDatabase::class, Store::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set a custom database name generator
        DatabaseConfig::$databaseNameGenerator = function (TenantWithDatabase $tenant) {
            // Use the numeric ID directly
            return 'store_' . $tenant->getTenantKey();
        };
    }
}
