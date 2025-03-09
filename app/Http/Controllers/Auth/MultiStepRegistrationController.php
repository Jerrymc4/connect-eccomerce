<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class MultiStepRegistrationController extends Controller
{
    /**
     * Show the plan selection page (Step 1).
     *
     * @return \Illuminate\View\View
     */
    public function showPlans()
    {
        $plans = Plan::getActivePlans();
        return view('auth.register-steps.plans', compact('plans'));
    }

    /**
     * Process plan selection and redirect to account creation (Step 1 -> Step 2).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        session(['selected_plan' => $plan->id]);

        return redirect()->route('register.account');
    }

    /**
     * Backward compatibility method - redirects to showAccount.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAccountForm()
    {
        return $this->showAccount();
    }

    /**
     * Show the account creation form (Step 2).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAccount()
    {
        if (!session('selected_plan')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please select a plan first.');
        }

        $plan = Plan::findOrFail(session('selected_plan'));
        return view('auth.register-steps.account', compact('plan'));
    }

    /**
     * Process account creation and redirect to billing or store setup (Step 2 -> Step 3/4).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(Request $request)
    {
        if (!session('selected_plan')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please select a plan first.');
        }

        $plan = Plan::findOrFail(session('selected_plan'));

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Use transaction to ensure data consistency
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => User::TYPE_STORE_OWNER,
            ]);

            event(new Registered($user));

            // Store registration data in session for next steps
            session([
                'registration_data' => [
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email
                ]
            ]);

            DB::connection(config('tenancy.database.central_connection'))->commit();

            // If plan is free, redirect to store setup
            if ($plan->price <= 0) {
                return redirect()->route('register.store');
            }

            // Otherwise, redirect to billing
            return redirect()->route('register.billing');
        } catch (\Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            
            return back()->withInput()->withErrors(['email' => $e->getMessage()]);
        }
    }

    /**
     * Show the billing information form (Step 3 - for paid plans only).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showBilling()
    {
        if (!session('registration_data') || !session('selected_plan')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        $plan = Plan::findOrFail(session('selected_plan'));
        
        // If plan is free, skip billing
        if ($plan->price <= 0) {
            return redirect()->route('register.store');
        }

        return view('auth.register-steps.billing', compact('plan'));
    }

    /**
     * Process billing information and redirect to store setup (Step 3 -> Step 4).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processBilling(Request $request)
    {
        // This is a placeholder for Stripe integration
        // In a real implementation, you would:
        // 1. Validate payment details
        // 2. Create Stripe customer and subscription
        // 3. Store Stripe customer ID and subscription ID

        // For now, just redirect to store setup
        return redirect()->route('register.store');
    }

    /**
     * Show the store setup form (Step 3).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showStore(Request $request)
    {
        if (!session('registration_data')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        // If we're coming back from a form submission, store the old input in session
        if ($request->old()) {
            session(['store_form_data' => $request->old()]);
        }

        return view('auth.register-steps.store');
    }

    /**
     * Backward compatibility method - redirects to showStore.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showStoreForm(Request $request)
    {
        return $this->showStore($request);
    }

    /**
     * Process store setup and complete registration (Step 4 -> Complete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createStore(Request $request)
    {
        if (!session('registration_data')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        try {
            $validated = $request->validate([
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

            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            $registrationData = session('registration_data');
            $user = User::findOrFail($registrationData['user_id']);

            // Store form data in session before proceeding
            session(['store_form_data' => $request->all()]);

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
            session()->forget(['registration_data', 'selected_plan', 'store_form_data']);

            // Now log in the user
            Auth::login($user);

            session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');

            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            \Illuminate\Support\Facades\Log::error('Store creation error: ' . $e->getMessage());
            
            // Store form data in session before returning with error
            session(['store_form_data' => $request->all()]);
            
            return back()->withInput()->withErrors(['error' => 'Failed to create store. Please try again.']);
        }
    }

    /**
     * Show the store onboarding page (Final step).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showOnboarding()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('home');
        }

        return view('store.onboarding', compact('store'));
    }

    /**
     * Complete the onboarding process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeOnboarding(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('home');
        }

        // Mark store setup as complete
        $store->markSetupComplete();

        // Redirect to the store dashboard
        $domain = $store->domains->first();
        if ($domain) {
            return redirect()->away("https://{$domain->domain}/dashboard");
        }

        return redirect()->route('home');
    }
}
