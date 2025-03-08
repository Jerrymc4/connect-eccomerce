<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the user types
     */
    const TYPE_ADMIN = 'admin';
    const TYPE_STORE_OWNER = 'store_owner';

    /**
     * Get all stores owned by the user.
     */
    public function ownedStores()
    {
        return $this->hasMany(Store::class, 'owner_id');
    }

    /**
     * Check if the user is a system admin.
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    /**
     * Check if the user is a store owner.
     * 
     * @return bool
     */
    public function isStoreOwner(): bool
    {
        return $this->user_type === self::TYPE_STORE_OWNER;
    }
}
