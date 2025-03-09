<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find a user by Google ID
     *
     * @param string $googleId
     * @return User|null
     */
    public function findByGoogleId(string $googleId): ?User;

    /**
     * Update a user
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool;

    /**
     * Get all store owners
     *
     * @return Collection
     */
    public function getAllStoreOwners(): Collection;
} 