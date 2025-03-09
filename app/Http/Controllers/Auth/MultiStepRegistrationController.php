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
     * Show the account creation form (Step 2).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showAccountForm()
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

            // Log the user in
            Auth::login($user);

            // Store user ID in session for next steps
            session(['registration_user_id' => $user->id]);

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
    public function showBillingForm()
    {
        if (!session('selected_plan') || !session('registration_user_id')) {
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
     * Show the store setup form (Step 4).
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showStoreForm()
    {
        if (!session('selected_plan') || !session('registration_user_id')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        $plan = Plan::findOrFail(session('selected_plan'));
        return view('auth.register-steps.store', compact('plan'));
    }

    /**
     * Process store setup and complete registration (Step 4 -> Complete).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createStore(Request $request)
    {
        if (!session('selected_plan') || !session('registration_user_id')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        $plan = Plan::findOrFail(session('selected_plan'));
        $user = User::findOrFail(session('registration_user_id'));

        $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
        ]);

        try {
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            // Generate a subdomain from the store name
            $storeName = $request->store_name;
            $storeSlug = Str::slug($storeName);
            $storeDomain = $storeSlug . '.' . config('app.url_base', 'example.com');

            // Create a store for the user with the selected plan
            $store = Store::createStore(
                $storeName,
                $storeDomain,
                $user->email,
                [
                    'owner_name' => $user->name,
                    'owner_email' => $user->email,
                    'status' => 'active',
                    'slug' => $storeSlug,
                    'plan_id' => $plan->id,
                    'subscription_status' => $plan->price <= 0 ? 'active' : 'pending',
                    'setup_status' => 'incomplete',
                ]
            );

            // Link store to user
            $store->updateOwner($user);

            DB::connection(config('tenancy.database.central_connection'))->commit();

            // Clear registration session data
            session()->forget(['selected_plan', 'registration_user_id']);

            // Flash a success message
            session()->flash('success', 'Your store has been created successfully! Let\'s set up your store.');

            // Redirect to the onboarding process
            return redirect()->route('store.onboarding');
        } catch (\Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            
            return back()->withInput()->withErrors(['store_name' => $e->getMessage()]);
        }
    }

    /**
     * Show the store onboarding page (Final step).
     *
     * @return \Illuminate\View\View
     */
    public function showOnboarding()
    {
        $user = Auth::user();
        $store = $user->ownedStores()->latest()->first();

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
        $store = $user->ownedStores()->latest()->first();

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
