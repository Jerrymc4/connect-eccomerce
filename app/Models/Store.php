<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Support\Str;

/**
 * Store represents an ecommerce store in our multi-tenant system.
 */
class Store extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stores';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'business_name',
        'tax_id',
        'phone',
        'email',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'logo_url',
        'plan',
        'subscription_ends_at',
        'owner_id',
        'owner_name',
        'owner_email',
        'data',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'subscription_ends_at' => 'datetime',
    ];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
    
    /**
     * Get tenant key identifier
     * 
     * @return string|int
     */
    public function getTenantKeyIdentifier()
    {
        return 'id';
    }
    
    /**
     * Get tenant key
     * 
     * @return string|int
     */
    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyIdentifier());
    }

    /**
     * Get a human-readable identifier for this store.
     * 
     * @return string
     */
    public function getStoreName(): string
    {
        return $this->name ?? 'Store ' . $this->id;
    }

    /**
     * Get the full URL for this store.
     * 
     * @return string|null
     */
    public function getStoreUrl(): ?string
    {
        $domain = $this->domains->first();
        return $domain ? "https://{$domain->domain}" : null;
    }

    /**
     * Get all stores in the system.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllStores()
    {
        return self::with('domains')->get();
    }
    
    /**
     * Create a new store.
     * 
     * @param string $name
     * @param string $domain
     * @param string $email
     * @param array $additionalData
     * @return Store
     */
    public static function createStore(string $name, string $domain, string $email, array $additionalData = []): self
    {
        // Create the store with basic data
        $store = new self();
        $store->name = $name;
        $store->slug = Str::slug($name);
        $store->owner_email = $email;
        
        // Apply additional data if provided
        foreach ($additionalData as $key => $value) {
            if (in_array($key, (new self())->fillable)) {
                $store->{$key} = $value;
            }
        }
        
        $store->save();
        
        // Create domain for the store
        $store->domains()->create(['domain' => $domain]);
        
        return $store;
    }

    /**
     * Get the owner of the store.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Update the owner of the store.
     * 
     * @param User $user
     * @return void
     */
    public function updateOwner(User $user): void
    {
        $this->owner_id = $user->id;
        $this->owner_name = $user->name;
        $this->owner_email = $user->email;
        $this->save();
    }
}
