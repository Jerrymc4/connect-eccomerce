<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProductRepositoryInterface
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Find products by category
     * 
     * @param int $categoryId
     * @return Collection
     */
    public function findByCategory(int $categoryId): Collection;
    
    /**
     * Find featured products
     * 
     * @param int $limit
     * @return Collection
     */
    public function findFeatured(int $limit = 10): Collection;
    
    /**
     * Find products on sale
     * 
     * @return Collection
     */
    public function findOnSale(): Collection;
    
    /**
     * Search products by name or description
     * 
     * @param string $term
     * @return Collection
     */
    public function search(string $term): Collection;
    
    /**
     * Find products by status
     * 
     * @param string $status
     * @return Collection
     */
    public function findByStatus(string $status): Collection;
    
    /**
     * Get low stock products
     * 
     * @param int $threshold
     * @return Collection
     */
    public function getLowStock(int $threshold = 5): Collection;
} 