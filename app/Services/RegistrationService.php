<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\StoreRepositoryInterface;
use App\DataTransferObjects\RegistrationData;
use App\Models\Plan;
use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class RegistrationService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private StoreRepositoryInterface $storeRepository
    ) {}

    /**
     * Create a new user account
     *
     * @param RegistrationData $data
     * @return User
     * @throws Exception
     */
    public function createAccount(RegistrationData $data): User
    {
        try {
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            $user = $this->userRepository->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'user_type' => User::TYPE_STORE_OWNER,
            ]);

            event(new Registered($user));

            DB::connection(config('tenancy.database.central_connection'))->commit();

            return $user;
        } catch (Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            throw $e;
        }
    }

    /**
     * Create a new store for a user
     *
     * @param User $user
     * @param RegistrationData $data
     * @return Store
     * @throws Exception
     */
    public function createStore(User $user, RegistrationData $data): Store
    {
        if (!$data->storeData) {
            throw new Exception('Store data is required');
        }

        try {
            DB::connection(config('tenancy.database.central_connection'))->beginTransaction();

            $storeSlug = Str::slug($data->storeData['name']);
            $storeDomain = $storeSlug . '.' . config('app.url_base', 'example.com');
            xdebug_break();

            $store = $this->storeRepository->create(
                name: $data->storeData['name'],
                domain: $storeDomain,
                email: $data->storeData['email'],
                data: $data->storeData
            );

            $store->updateOwner($user);

            DB::connection(config('tenancy.database.central_connection'))->commit();

            return $store;
        } catch (Exception $e) {
            DB::connection(config('tenancy.database.central_connection'))->rollBack();
            throw $e;
        }
    }

    /**
     * Process billing information
     *
     * @param User $user
     * @param RegistrationData $data
     * @return bool
     */
    public function processBilling(User $user, RegistrationData $data): bool
    {
        // This is a placeholder for Stripe integration
        // In a real implementation, you would:
        // 1. Validate payment details
        // 2. Create Stripe customer and subscription
        // 3. Store Stripe customer ID and subscription ID
        return true;
    }

    /**
     * Get the selected plan
     *
     * @param int $planId
     * @return Plan
     */
    public function getPlan(int $planId): Plan
    {
        return Plan::findOrFail($planId);
    }

    /**
     * Store form data in session
     *
     * @param array $data
     * @param string $key
     * @return void
     */
    public function storeFormData(array $data, string $key = 'store_form_data'): void
    {
        session([$key => $data]);
    }

    /**
     * Clear registration data from session
     *
     * @return void
     */
    public function clearRegistrationData(): void
    {
        session()->forget([
            'registration_data',
            'selected_plan',
            'store_form_data'
        ]);
    }
} 