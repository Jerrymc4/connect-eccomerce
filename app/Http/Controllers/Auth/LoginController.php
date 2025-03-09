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
            
            if ($user->user_type === \App\Models\User::TYPE_ADMIN) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->user_type === \App\Models\User::TYPE_STORE_OWNER) {
                // Get the store if it exists
                $store = $user->store;
                
                if ($store) {
                    // Get the store URL if available
                    $domain = $store->domains->first();
                    
                    if ($domain) {
                        return redirect()->away("https://{$domain->domain}");
                    }
                }
                
                // Otherwise, go to dashboard
                return redirect()->intended(route('admin.dashboard'));
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