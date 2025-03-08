<?php

namespace App\Http\Middleware;

use App\Services\StoreAuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreAuthenticate
{
    protected $storeAuthService;

    public function __construct(StoreAuthService $storeAuthService)
    {
        $this->storeAuthService = $storeAuthService;
    }

    /**
     * Handle an incoming request for store authentication.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as store owner or staff
        if (!$this->storeAuthService->isAuthenticatedAsOwner() && !$this->storeAuthService->isAuthenticatedAsStaff()) {
            // Get current domain to redirect back after login
            $currentUrl = $request->url();
            $host = $request->getHost();
            
            // Redirect to login page on the same domain
            return redirect()->to('//' . $host . '/login')->with([
                'intended' => $currentUrl,
                'message' => 'Please log in to access this store'
            ]);
        }

        return $next($request);
    }
} 