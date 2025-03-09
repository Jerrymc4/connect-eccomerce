<?php

namespace App\Contracts\Repositories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface StoreRepositoryInterface
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
    public function create(string $name, string $domain, string $email, array $data = []): Store;

    /**
     * Find a store by domain
     *
     * @param string $domain
     * @return Store|null
     */
    public function findByDomain(string $domain): ?Store;

    /**
     * Find a store by slug
     *
     * @param string $slug
     * @return Store|null
     */
    public function findBySlug(string $slug): ?Store;

    /**
     * Get all stores
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get stores by owner
     *
     * @param User $user
     * @return Store|null
     */
    public function getByOwner(User $user): ?Store;

    /**
     * Update a store
     *
     * @param Store $store
     * @param array $data
     * @return bool
     */
    public function update(Store $store, array $data): bool;

    /**
     * Delete a store
     *
     * @param Store $store
     * @return bool
     */
    public function delete(Store $store): bool;
} 