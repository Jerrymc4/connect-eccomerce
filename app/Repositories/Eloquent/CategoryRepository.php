<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CategoryRepository
 */
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Category::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getActive(): Collection
    {
        return $this->model->where('is_active', true)->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTopLevel(): Collection
    {
        return $this->model->whereNull('parent_id')->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getChildren(int $parentId): Collection
    {
        return $this->model->where('parent_id', $parentId)->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getWithProductCounts(): Collection
    {
        return $this->model->withCount('products')->get();
    }
} 