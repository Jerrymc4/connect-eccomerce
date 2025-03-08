<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
                
            // Store-specific routes
            if ($this->app->environment('local') || $this->isStoreDomain()) {
                Route::middleware('web')
                    ->group(base_path('routes/store.php'));
            }
        });
    }
    
    /**
     * Determine if the current request is for a store domain.
     *
     * @return bool
     */
    protected function isStoreDomain(): bool
    {
        $host = request()->getHost();
        
        // Check if this is a store domain in the database
        return \App\Models\Store::whereHas('domains', function ($query) use ($host) {
            $query->where('domain', $host);
        })->exists();
    }
} 