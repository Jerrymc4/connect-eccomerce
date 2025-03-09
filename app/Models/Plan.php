<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'stripe_plan_id',
        'price',
        'billing_period',
        'description',
        'is_featured',
        'is_active',
        'max_products',
        'max_categories',
        'max_staff_accounts',
        'features',
        'has_custom_domain',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'float',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'max_products' => 'integer',
        'max_categories' => 'integer',
        'max_staff_accounts' => 'integer',
        'features' => 'array',
        'has_custom_domain' => 'boolean',
    ];

    /**
     * Get the stores that belong to this plan.
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    /**
     * Get only active plans.
     */
    public static function getActivePlans()
    {
        return self::where('is_active', true)->get();
    }

    /**
     * Format the price for display.
     */
    public function formattedPrice(): string
    {
        return '$' . number_format($this->price, 2);
    }
}
