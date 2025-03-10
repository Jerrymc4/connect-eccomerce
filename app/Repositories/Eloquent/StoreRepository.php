<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\StoreRepositoryInterface;
use App\Models\Store;
use App\Models\User;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * Create a new store
     *
     * @param string $name
     * @param string $domain
     * @param string $email
     * @param array $data
     * @return Store
     */
    public function create(string $name, string $domain, string $email, array $data = []): Store
    {
        $store = new Store();
        $store->name = $name;
        $store->slug = Str::slug($name);
        $store->email = $email;
        $store->fill($data);
        $store->save();

        // Create domain for the store
        $storeDomain = new Domain();
        $storeDomain->domain = $domain;
        $storeDomain->store_id = $store->id;
        $storeDomain->save();

        return $store;
    }

    /**
     * Find a store by domain
     *
     * @param string $domain
     * @return Store|null
     */
    public function findByDomain(string $domain): ?Store
    {
        return Store::whereHas('domains', function ($query) use ($domain) {
            $query->where('domain', $domain);
        })->first();
    }

    /**
     * Find a store by slug
     *
     * @param string $slug
     * @return Store|null
     */
    public function findBySlug(string $slug): ?Store
    {
        return Store::where('slug', $slug)->first();
    }

    /**
     * Get all stores
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Store::all();
    }

    /**
     * Get stores by owner
     *
     * @param User $user
     * @return Store|null
     */
    public function getByOwner(User $user): ?Store
    {
        return Store::where('owner_id', $user->id)->first();
    }

    /**
     * Update a store
     *
     * @param Store $store
     * @param array $data
     * @return bool
     */
    public function update(Store $store, array $data): bool
    {
        return $store->update($data);
    }

    /**
     * Delete a store
     *
     * @param Store $store
     * @return bool
     */
    public function delete(Store $store): bool
    {
        return $store->delete();
    }

    /**
     * Get all stores with their domains.
     *
     * @return Collection
     */
    public function getAllWithDomains(): Collection
    {
        return Store::with('domains')->get();
    }

    /**
     * Find a store by ID with its domains.
     *
     * @param int $id
     * @return Store|null
     */
    public function findWithDomains(int $id): ?Store
    {
        return Store::with('domains')->find($id);
    }
} 