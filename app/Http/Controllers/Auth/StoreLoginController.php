<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\StoreAuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoreLoginController extends Controller
{
    protected $storeAuthService;

    public function __construct(StoreAuthService $storeAuthService)
    {
        $this->storeAuthService = $storeAuthService;
    }

    /**
     * Display the login view for a specific store.
     */
    public function show(Request $request)
    {
        // Get the current domain
        $host = $request->getHost();
        
        // Find the store for this domain
        $store = Store::whereHas('domains', function ($query) use ($host) {
            $query->where('domain', $host);
        })->first();
        
        if (!$store) {
            abort(404, 'Store not found');
        }
        
        return view('auth.store-login', [
            'store' => $store
        ]);
    }

    /**
     * Handle an authentication attempt for a store.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Get the current domain
        $host = $request->getHost();
        
        // Find the store for this domain
        $store = Store::whereHas('domains', function ($query) use ($host) {
            $query->where('domain', $host);
        })->first();
        
        if (!$store) {
            abort(404, 'Store not found');
        }
        
        // Attempt authentication against store context
        $authData = $this->storeAuthService->authenticate(
            $credentials['email'], 
            $credentials['password'], 
            $store
        );
        
        if ($authData) {
            // Login was successful
            $this->storeAuthService->login($authData);
            $request->session()->regenerate();
            
            return redirect()->intended(route('store.dashboard'));
        }
        
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }
} 