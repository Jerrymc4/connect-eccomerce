<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoryRepositoryInterface
 */
interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all active categories
     * 
     * @return Collection
     */
    public function getActive(): Collection;
    
    /**
     * Get all top-level categories (no parent)
     * 
     * @return Collection
     */
    public function getTopLevel(): Collection;
    
    /**
     * Get child categories of a parent category
     * 
     * @param int $parentId
     * @return Collection
     */
    public function getChildren(int $parentId): Collection;
    
    /**
     * Get categories with product counts
     * 
     * @return Collection
     */
    public function getWithProductCounts(): Collection;
} 