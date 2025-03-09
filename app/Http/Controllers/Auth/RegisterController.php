<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
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
     * Display the registration view (plans page).
     */
    public function show()
    {
        return view('auth.register-steps.plans');
    }

    /**
     * Display the account creation step.
     */
    public function showAccountStep()
    {
        return view('auth.register-steps.account');
    }

    /**
     * Display the store setup step.
     */
    public function showStoreStep()
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }

        return view('auth.register-steps.store');
    }

    /**
     * Handle account creation step.
     */
    public function createAccount(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Store the account data in session
        session(['registration_data' => [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]]);

        return redirect()->route('register.store');
    }

    /**
     * Handle store creation and complete registration.
     */
    public function createStore(Request $request)
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'business_name' => ['required', 'string', 'max:255'],
            'tax_id' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:2'],
        ]);

        try {
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            $registrationData = session('registration_data');

            // Create the user
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'password' => Hash::make($registrationData['password']),
                'user_type' => User::TYPE_STORE_OWNER,
            ]);

            event(new Registered($user));

            // Generate store slug
            $storeSlug = Str::slug($request->name);
            $storeDomain = $storeSlug . '.' . config('app.url_base', 'example.com');

            // Create the store
            $store = Store::createStore(
                $request->name,
                $storeDomain,
                $request->email,
                [
                    'description' => $request->description,
                    'business_name' => $request->business_name,
                    'tax_id' => $request->tax_id,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'owner_name' => $user->name,
                    'owner_email' => $user->email,
                    'status' => 'active',
                    'slug' => $storeSlug,
                ]
            );

            // Link store to user
            $store->updateOwner($user);

            DB::connection(config('tenancy.database.central_connection'))->commit();

            // Clear registration data from session
            session()->forget('registration_data');

            Auth::login($user);

            session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');

            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            \Illuminate\Support\Facades\Log::error('Store creation error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to create store. Please try again.']);
        }
    }
} 