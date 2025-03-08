<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default permissions
        $permissions = Permission::getDefaultPermissions();
        $permissionInstances = [];

        foreach ($permissions as $permission) {
            $permissionInstances[$permission['name']] = Permission::create($permission);
        }

        // Create default roles
        $roles = Role::getDefaultRoles();
        $roleInstances = [];

        foreach ($roles as $role) {
            $roleInstances[$role['name']] = Role::create($role);
        }

        // Assign permissions to roles
        // Admin role gets all permissions
        $roleInstances[Role::ADMIN]->permissions()->attach(array_values($permissionInstances));

        // Manager role gets most permissions except staff management
        $managerPermissions = array_filter($permissionInstances, function($permission) {
            return $permission->name !== Permission::MANAGE_STAFF;
        });
        $roleInstances[Role::MANAGER]->permissions()->attach(array_values($managerPermissions));

        // Staff role gets basic permissions
        $staffPermissions = array_filter($permissionInstances, function($permission) {
            return in_array($permission->name, [
                Permission::VIEW_DASHBOARD,
                Permission::VIEW_PRODUCTS,
                Permission::VIEW_ORDERS,
                Permission::VIEW_CUSTOMERS,
            ]);
        });
        $roleInstances[Role::STAFF]->permissions()->attach(array_values($staffPermissions));

        // Cashier role gets order-related permissions
        $cashierPermissions = array_filter($permissionInstances, function($permission) {
            return in_array($permission->name, [
                Permission::VIEW_DASHBOARD,
                Permission::VIEW_PRODUCTS,
                Permission::MANAGE_ORDERS,
                Permission::VIEW_ORDERS,
                Permission::VIEW_CUSTOMERS,
            ]);
        });
        $roleInstances[Role::CASHIER]->permissions()->attach(array_values($cashierPermissions));

        // Create default admin staff
        $admin = Staff::create([
            'name' => 'Store Admin',
            'email' => 'admin@store.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role' => Role::ADMIN,
            'status' => 'active',
        ]);

        // Assign admin role
        $admin->roles()->attach($roleInstances[Role::ADMIN]);

        // Create a regular staff member
        $staff = Staff::create([
            'name' => 'Store Staff',
            'email' => 'staff@store.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'role' => Role::STAFF,
            'status' => 'active',
        ]);

        // Assign staff role
        $staff->roles()->attach($roleInstances[Role::STAFF]);
    }
} 