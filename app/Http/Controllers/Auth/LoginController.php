<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on user type
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isStoreOwner()) {
                // If they have only one store, redirect to it
                $stores = $user->ownedStores;
                
                if ($stores->count() === 1) {
                    // Get the store URL if available
                    $store = $stores->first();
                    $domain = $store->domains->first();
                    
                    if ($domain) {
                        return redirect()->away("https://{$domain->domain}");
                    }
                }
                
                // Otherwise, go to stores list
                return redirect()->intended(route('admin.stores.index'));
            }

            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
} 