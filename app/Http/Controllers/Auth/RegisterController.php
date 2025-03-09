<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function show()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'store_name' => ['required', 'string', 'max:255'],
        ]);

        try {
            // Explicitly use the central database connection
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            // By default, new users are store owners
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => User::TYPE_STORE_OWNER,
            ]);

            event(new Registered($user));

            // Generate a subdomain from the store name
            $storeName = $request->store_name;
            $storeSlug = Str::slug($storeName);
            $storeDomain = $storeSlug . '.' . config('app.url_base', 'example.com');

            // Create a store for the new user
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

            DB::connection(config('tenancy.database.central_connection'))->commit();

            Auth::login($user);

            // Flash a success message
            session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');

            // Redirect to home route which will handle redirection based on user type
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            
            // Log error for debugging
            \Illuminate\Support\Facades\Log::error('Registration error: ' . $e->getMessage());
            
            return back()->withInput()->withErrors(['email' => $e->getMessage()]);
        }
    }
} 