<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductRepository
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Product::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByCategory(int $categoryId): Collection
    {
        return $this->model->where('category_id', $categoryId)->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findFeatured(int $limit = 10): Collection
    {
        return $this->model->where('featured', true)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findOnSale(): Collection
    {
        return $this->model->whereNotNull('sale_price')
            ->where('status', 'published')
            ->where('sale_price', '>', 0)
            ->where('sale_price', '<', DB::raw('price'))
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function search(string $term): Collection
    {
        return $this->model->where('name', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%")
            ->where('status', 'published')
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLowStock(int $threshold = 5): Collection
    {
        return $this->model->where('stock', '<=', $threshold)
            ->where('stock', '>', 0)
            ->where('status', 'published')
            ->get();
    }
} 