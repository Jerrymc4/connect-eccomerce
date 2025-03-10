<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Database\Concerns\TenantRun;

/**
 * Store represents an ecommerce store in our multi-tenant system.
 */
class Store extends BaseTenant implements TenantWithDatabase, Tenant
{
    use HasDatabase, HasDomains, TenantRun;
    
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
        'plan_id',
        'subscription_status',
        'subscription_ends_at',
        'stripe_customer_id',
        'stripe_subscription_id',
        'setup_status',
        'owner_id',
        'owner_name',
        'owner_email',
        'data',
        'tenancy_db_name',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'subscription_ends_at' => 'datetime',
        'setup_status' => 'string',
    ];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
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
     * Get the value of the key used for identifying the tenant.
     */
    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
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
        try {
            // Insert with explicit columns
            $id = DB::table('stores')->insertGetId([
                'name' => $name,
                'slug' => Str::slug($name),
                'domain' => $name,
                'email' => $email,
                'owner_email' => $email,
                'status' => 'active',
                'business_name' => $additionalData['business_name'] ?? null,
                'tax_id' => $additionalData['tax_id'] ?? null,
                'phone' => $additionalData['phone'] ?? null,
                'address_line1' => $additionalData['address_line1'] ?? null,
                'address_line2' => $additionalData['address_line2'] ?? null,
                'city' => $additionalData['city'] ?? null,
                'state' => $additionalData['state'] ?? null,
                'postal_code' => $additionalData['postal_code'] ?? null,
                'country' => $additionalData['country'] ?? null,
                'description' => $additionalData['description'] ?? null,
                'owner_name' => $additionalData['owner_name'] ?? null,
                'data' => json_encode($additionalData),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $store = self::find($id);
            $store->tenancy_db_name = 'store_' . $store->id;
            $store->save();

            // Create domain
            $store->domains()->create(['domain' => $domain]);
            
            try {
                // Initialize the tenant database
                Log::info('Creating database for store: ' . $store->id);
                $store->createDatabase();
                
                // Run migrations for the tenant database
                Log::info('Running migrations for store: ' . $store->id);
                $store->run(function ($store) {
                    $result = Artisan::call('migrate', [
                        '--force' => true,
                        '--path' => 'database/migrations/tenant',
                        '--database' => 'tenant'
                    ]);
                    
                    if ($result !== 0) {
                        Log::error('Migration failed for store: ' . $store->id . ' with exit code: ' . $result);
                        throw new \Exception('Failed to run migrations');
                    }
                    
                    Log::info('Migrations completed for store: ' . $store->id);
                });
            } catch (\Exception $e) {
                Log::error('Failed to setup tenant database: ' . $e->getMessage());
                throw $e;
            }
            
            return $store;
        } catch (\Exception $e) {
            Log::error('Failed to create store: ' . $e->getMessage());
            throw $e;
        }
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

    /**
     * Get the subscription plan of the store.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Check if the store setup is complete.
     * 
     * @return bool
     */
    public function isSetupComplete(): bool
    {
        return $this->setup_status === 'complete';
    }

    /**
     * Mark the store setup as complete.
     * 
     * @return void
     */
    public function markSetupComplete(): void
    {
        $this->setup_status = 'complete';
        $this->save();
    }

    /**
     * Check if the store has an active subscription.
     * 
     * @return bool
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->subscription_status === 'active') {
            return true;
        }
        
        if ($this->subscription_status === 'trial' && $this->subscription_ends_at && $this->subscription_ends_at->isFuture()) {
            return true;
        }
        
        return false;
    }

    public function createDomain($data): \Stancl\Tenancy\Contracts\Domain
    {
        $class = config('tenancy.domain_model');

        if (! is_array($data)) {
            $data = ['domain' => $data];
        }

        $domain = (new $class)->fill($data);
        $domain->store_id = $this->id;
        $domain->save();

        return $domain;
    }

    /**
     * Get the name of the key used for identifying the tenant.
     */
    public function getTenantKeyName(): string
    {
        return 'id';
    }

    /**
     * Get the value of an internal key.
     */
    public function getInternal(string $key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Set the value of an internal key.
     */
    public function setInternal(string $key, $value)
    {
        $this->setAttribute($key, $value);
        return $this;
    }

    public function createDatabase()
    {
        $config = $this->database();
        $manager = $config->manager();
        $manager->createDatabase($this);
    }
}
