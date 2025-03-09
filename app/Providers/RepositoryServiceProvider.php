<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\StoreRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\StoreRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the base repository
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        
        // Register specific repositories
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
        
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        
        // Add more repository bindings as needed
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
