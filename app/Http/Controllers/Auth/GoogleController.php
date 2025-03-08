<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            // Begin transaction
            \Illuminate\Support\Facades\DB::connection(config('tenancy.database.central_connection'))->beginTransaction();
            
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                // Check if user exists with same email
                $user = User::where('email', $googleUser->email)->first();
                
                if (!$user) {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'user_type' => User::TYPE_STORE_OWNER, // Default to store owner
                    ]);
                    
                    // Create a default store for the user
                    $storeName = $googleUser->name . "'s Store";
                    $storeSlug = Str::slug($storeName);
                    $storeDomain = $storeSlug . '.' . config('app.url_base', 'example.com');
                    
                    // Create the store
                    $store = \App\Models\Store::createStore(
                        $storeName,
                        $storeDomain,
                        $user->email,
                        [
                            'owner_name' => $user->name,
                            'owner_email' => $user->email,
                            'status' => 'active',
                            'slug' => $storeSlug,
                        ]
                    );
                    
                    // Link store to user
                    $store->updateOwner($user);
                    
                    // Flash a success message
                    session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');
                } else {
                    // Update existing user with Google ID
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }
            }
            
            // Login the user
            Auth::login($user);
            
            \Illuminate\Support\Facades\DB::connection(config('tenancy.database.central_connection'))->commit();

            // Redirect based on user type
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isStoreOwner()) {
                // If they have stores, check count
                $stores = $user->ownedStores;
                
                if ($stores->count() === 0) {
                    // No stores yet, redirect to home route
                    session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');
                    return redirect()->route('home');
                } elseif ($stores->count() === 1) {
                    // One store, redirect to it
                    $store = $stores->first();
                    $domain = $store->domains->first();
                    
                    if ($domain) {
                        return redirect()->away("https://{$domain->domain}");
                    }
                }
                
                // Multiple stores, go to stores list
                return redirect()->route('admin.stores.index');
            }
            
            return redirect()->route('home');
            
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed: ' . $e->getMessage());
        }
    }
} 