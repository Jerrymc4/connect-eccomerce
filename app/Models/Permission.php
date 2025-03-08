<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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
        'category',
    ];

    /**
     * Define permission categories
     */
    const CATEGORY_PRODUCTS = 'products';
    const CATEGORY_ORDERS = 'orders';
    const CATEGORY_CUSTOMERS = 'customers';
    const CATEGORY_STAFF = 'staff';
    const CATEGORY_SETTINGS = 'settings';
    const CATEGORY_REPORTS = 'reports';

    /**
     * Define common permissions
     */
    const VIEW_DASHBOARD = 'view_dashboard';
    const MANAGE_PRODUCTS = 'manage_products';
    const VIEW_PRODUCTS = 'view_products';
    const MANAGE_ORDERS = 'manage_orders';
    const VIEW_ORDERS = 'view_orders';
    const MANAGE_CUSTOMERS = 'manage_customers';
    const VIEW_CUSTOMERS = 'view_customers';
    const MANAGE_STAFF = 'manage_staff';
    const VIEW_STAFF = 'view_staff';
    const MANAGE_SETTINGS = 'manage_settings';
    const VIEW_REPORTS = 'view_reports';

    /**
     * Get all roles that have this permission
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * Get default store permissions
     * 
     * @return array
     */
    public static function getDefaultPermissions(): array
    {
        return [
            [
                'name' => self::VIEW_DASHBOARD,
                'display_name' => 'View Dashboard',
                'description' => 'Can view the store dashboard',
                'category' => 'general'
            ],
            [
                'name' => self::MANAGE_PRODUCTS,
                'display_name' => 'Manage Products',
                'description' => 'Can create, edit, and delete products',
                'category' => self::CATEGORY_PRODUCTS
            ],
            [
                'name' => self::VIEW_PRODUCTS,
                'display_name' => 'View Products',
                'description' => 'Can view products',
                'category' => self::CATEGORY_PRODUCTS
            ],
            [
                'name' => self::MANAGE_ORDERS,
                'display_name' => 'Manage Orders',
                'description' => 'Can create, edit, and process orders',
                'category' => self::CATEGORY_ORDERS
            ],
            [
                'name' => self::VIEW_ORDERS,
                'display_name' => 'View Orders',
                'description' => 'Can view orders',
                'category' => self::CATEGORY_ORDERS
            ],
            [
                'name' => self::MANAGE_CUSTOMERS,
                'display_name' => 'Manage Customers',
                'description' => 'Can create, edit, and delete customers',
                'category' => self::CATEGORY_CUSTOMERS
            ],
            [
                'name' => self::VIEW_CUSTOMERS,
                'display_name' => 'View Customers',
                'description' => 'Can view customers',
                'category' => self::CATEGORY_CUSTOMERS
            ],
            [
                'name' => self::MANAGE_STAFF,
                'display_name' => 'Manage Staff',
                'description' => 'Can create, edit, and delete staff members',
                'category' => self::CATEGORY_STAFF
            ],
            [
                'name' => self::VIEW_STAFF,
                'display_name' => 'View Staff',
                'description' => 'Can view staff members',
                'category' => self::CATEGORY_STAFF
            ],
            [
                'name' => self::MANAGE_SETTINGS,
                'display_name' => 'Manage Settings',
                'description' => 'Can manage store settings',
                'category' => self::CATEGORY_SETTINGS
            ],
            [
                'name' => self::VIEW_REPORTS,
                'display_name' => 'View Reports',
                'description' => 'Can view store reports',
                'category' => self::CATEGORY_REPORTS
            ],
        ];
    }
} 