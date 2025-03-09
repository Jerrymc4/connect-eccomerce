<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Contracts\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Find a user by Google ID
     *
     * @param string $googleId
     * @return User|null
     */
    public function findByGoogleId(string $googleId): ?User
    {
        return User::where('google_id', $googleId)->first();
    }

    /**
     * Update a user
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Get all store owners
     *
     * @return Collection
     */
    public function getAllStoreOwners(): Collection
    {
        return User::where('user_type', User::TYPE_STORE_OWNER)->get();
    }
} 