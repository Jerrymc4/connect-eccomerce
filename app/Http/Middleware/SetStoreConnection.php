<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetStoreConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('current_store_id')) {
            $storeId = session('current_store_id');
            
            // Set the default database connection to the store connection
            DB::setDefaultConnection("store_{$storeId}");
            
            // Add the store ID to the request for easy access in controllers
            $request->attributes->add(['store_id' => $storeId]);
        }

        return $next($request);
    }
} 