<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\CreateStoreRequest;
use App\Models\Plan;
use App\Models\Store;
use App\Models\User;
use App\Services\RegistrationService;
use App\DataTransferObjects\RegistrationData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class  MultiStepRegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService
    ) {}

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

        $plan = $this->registrationService->getPlan($request->plan_id);
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

        $plan = $this->registrationService->getPlan(session('selected_plan'));
        return view('auth.register-steps.account', compact('plan'));
    }

    /**
     * Process account creation and redirect to billing or store setup (Step 2 -> Step 3/4).
     *
     * @param  CreateAccountRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccount(CreateAccountRequest $request)
    {
        if (!session('selected_plan')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please select a plan first.');
        }

        try {
            $registrationData = RegistrationData::fromAccountRequest($request->validated());
            $user = $this->registrationService->createAccount($registrationData);

            // Store registration data in session for next steps
            session([
                'registration_data' => [
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password
                ]
            ]);

            $plan = $this->registrationService->getPlan(session('selected_plan'));

            // If plan is free, redirect to store setup
            if ($plan->price <= 0) {
                return redirect()->route('register.store');
            }

            // Otherwise, redirect to billing
            return redirect()->route('register.billing');
        } catch (\Exception $e) {
            Log::error('Account creation error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['email' => 'Failed to create account. Please try again.']);
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

        $plan = $this->registrationService->getPlan(session('selected_plan'));
        
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
        if (!session('registration_data') || !session('selected_plan')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        $registrationData = session('registration_data');
        $user = User::findOrFail($registrationData['user_id']);

        try {
            $this->registrationService->processBilling($user, new RegistrationData(
                name: $registrationData['name'],
                email: $registrationData['email'],
                password: $registrationData['password'],
                planId: session('selected_plan'),
                billingData: $request->all()
            ));

            return redirect()->route('register.store');
        } catch (\Exception $e) {
            Log::error('Billing processing error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Failed to process billing. Please try again.']);
        }
    }

    /**
     * Show the store setup form (Step 3).
     *
     * @param  \Illuminate\Http\Request  $request
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
            $this->registrationService->storeFormData($request->old());
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
     * @param  CreateStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createStore(CreateStoreRequest $request)
    {
        if (!session('registration_data')) {
            return redirect()->route('register.plans')
                ->with('error', 'Please start the registration process again.');
        }

        try {
            // Store form data in session before proceeding
            $this->registrationService->storeFormData($request->all());

            $registrationData = RegistrationData::fromStoreRequest($request->validated());
            $user = User::findOrFail(session('registration_data')['user_id']);
            
            $store = $this->registrationService->createStore($user, $registrationData);

            // Clear registration data from session
            $this->registrationService->clearRegistrationData();

            // Now log in the user
            Auth::login($user);

            session()->flash('success', 'Your store has been created successfully! You can customize it from your dashboard.');

            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Store creation error: ' . $e->getMessage());
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
