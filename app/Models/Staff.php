<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
        'phone',
        'position',
        'status',
        'last_login_at',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Check if staff member has admin privileges
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Get all roles associated with this staff member
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'staff_roles');
    }

    /**
     * Check if staff member has specific permission
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        // Admin has all permissions
        if ($this->is_admin) {
            return true;
        }

        // Check if any of the staff's roles have this permission
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all permissions for this staff member
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissions()
    {
        if ($this->is_admin) {
            // Admin has all permissions
            return Permission::all()->pluck('name');
        }

        // Combine permissions from all roles
        return $this->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique();
    }

    /**
     * Create a new staff member
     * 
     * @param array $data
     * @return self
     */
    public static function createStaff(array $data): self
    {
        $staff = new self();
        $staff->name = $data['name'];
        $staff->email = $data['email'];
        $staff->password = Hash::make($data['password']);
        $staff->role = $data['role'] ?? 'staff';
        $staff->is_admin = $data['is_admin'] ?? false;
        $staff->phone = $data['phone'] ?? null;
        $staff->position = $data['position'] ?? null;
        $staff->status = $data['status'] ?? 'active';
        $staff->save();

        // Assign role if provided
        if (isset($data['role_id'])) {
            $staff->roles()->attach($data['role_id']);
        }

        return $staff;
    }
} 