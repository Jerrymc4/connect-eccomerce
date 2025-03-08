<?php

namespace App\Services;

use App\Models\Store;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StoreAuthService
{
    /**
     * Authenticate a user in the store context.
     * This will check both admin database (for owners) and store database (for staff).
     * 
     * @param string $email
     * @param string $password
     * @param Store $store
     * @return array|null
     */
    public function authenticate(string $email, string $password, Store $store): ?array
    {
        // First check if this is the store owner
        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Check if this user is the owner of this store
            if ($store->owner_id == $user->id || $user->isAdmin()) {
                return [
                    'user' => $user,
                    'type' => 'owner',
                    'store' => $store,
                    'permissions' => ['*'] // Owners have all permissions
                ];
            }
        }

        // If not the owner, check if it's a staff member
        // Change database connection to store database
        $previousConnection = DB::getDefaultConnection();
        DB::setDefaultConnection("store_{$store->id}");

        try {
            $staff = Staff::where('email', $email)->first();

            if ($staff && Hash::check($password, $staff->password)) {
                return [
                    'user' => $staff,
                    'type' => 'staff',
                    'store' => $store,
                    'permissions' => $staff->getAllPermissions()
                ];
            }
        } finally {
            // Always restore the previous connection
            DB::setDefaultConnection($previousConnection);
        }

        return null;
    }

    /**
     * Log the user in based on context.
     * 
     * @param array $authData
     * @return bool
     */
    public function login(array $authData): bool
    {
        if ($authData['type'] === 'owner') {
            // Log in as central user
            Auth::guard('web')->login($authData['user']);
            session(['current_store_id' => $authData['store']->id]);
            session(['user_type' => 'owner']);
            return true;
        } else {
            // Log in as staff
            Auth::guard('store')->login($authData['user']);
            session(['current_store_id' => $authData['store']->id]);
            session(['user_type' => 'staff']);
            return true;
        }
    }

    /**
     * Promote a staff member to admin status within the store.
     * 
     * @param Staff $staff
     * @param Store $store
     * @return bool
     */
    public function promoteToStoreAdmin(Staff $staff, Store $store): bool
    {
        $previousConnection = DB::getDefaultConnection();
        DB::setDefaultConnection("store_{$store->id}");

        try {
            DB::beginTransaction();

            // Update the staff record
            $staff->is_admin = true;
            $staff->save();

            // Ensure they have the admin role
            $adminRole = \App\Models\Role::where('name', \App\Models\Role::ADMIN)->first();
            if ($adminRole) {
                // Remove existing roles and set to admin
                $staff->roles()->sync([$adminRole->id]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            DB::setDefaultConnection($previousConnection);
        }
    }

    /**
     * Determine if the current session is authenticated as a store owner.
     * 
     * @return bool
     */
    public function isAuthenticatedAsOwner(): bool
    {
        return Auth::guard('web')->check() && 
               session('user_type') === 'owner' && 
               session()->has('current_store_id');
    }

    /**
     * Determine if the current session is authenticated as a store staff.
     * 
     * @return bool
     */
    public function isAuthenticatedAsStaff(): bool
    {
        return Auth::guard('store')->check() && 
               session('user_type') === 'staff' && 
               session()->has('current_store_id');
    }

    /**
     * Check if the currently authenticated user has permission for an action.
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAuthenticatedAsOwner()) {
            // Store owners have all permissions
            return true;
        }

        if ($this->isAuthenticatedAsStaff()) {
            $staff = Auth::guard('store')->user();
            return $staff->hasPermission($permission);
        }

        return false;
    }
} 