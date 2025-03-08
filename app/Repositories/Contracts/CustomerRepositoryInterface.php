<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CustomerRepositoryInterface
 */
interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * Find customers by status
     * 
     * @param string $status
     * @return Collection
     */
    public function findByStatus(string $status): Collection;
    
    /**
     * Find customer by email
     * 
     * @param string $email
     * @return \App\Models\Customer|null
     */
    public function findByEmail(string $email);
    
    /**
     * Get customers with orders count
     * 
     * @return Collection
     */
    public function getWithOrdersCount(): Collection;
    
    /**
     * Get top customers by order total
     * 
     * @param int $limit
     * @return Collection
     */
    public function getTopCustomers(int $limit = 10): Collection;
    
    /**
     * Search customers by name or email
     * 
     * @param string $term
     * @return Collection
     */
    public function search(string $term): Collection;
} 