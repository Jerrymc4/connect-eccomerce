<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Stancl\Tenancy\Events\CreatingTenant;

class AutoIncrementIdServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Intercept CreatingTenant event to allow auto-increment to work naturally
        Event::listen(CreatingTenant::class, function (CreatingTenant $event) {
            // The tenant object already exists and its ID will be auto-assigned by the database
            // We don't need to do anything else in this listener
            // The presence of this listener prevents the default ID generator from running
        });
    }
}
