<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Define role constants
     */
    const ADMIN = 'admin';
    const MANAGER = 'manager';
    const STAFF = 'staff';
    const CASHIER = 'cashier';

    /**
     * Get all permissions for this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Get all staff members with this role
     */
    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'staff_roles');
    }

    /**
     * Check if role has specific permission
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains('name', $permission);
    }

    /**
     * Get default store roles
     * 
     * @return array
     */
    public static function getDefaultRoles(): array
    {
        return [
            [
                'name' => self::ADMIN,
                'display_name' => 'Administrator',
                'description' => 'Full access to all store features'
            ],
            [
                'name' => self::MANAGER,
                'display_name' => 'Store Manager',
                'description' => 'Manage store operations and staff'
            ],
            [
                'name' => self::STAFF,
                'display_name' => 'Staff Member',
                'description' => 'General staff with basic permissions'
            ],
            [
                'name' => self::CASHIER,
                'display_name' => 'Cashier',
                'description' => 'Process sales and handle customer transactions'
            ],
        ];
    }
} 