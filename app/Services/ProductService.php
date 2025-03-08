<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Str;

/**
 * Class ProductService
 */
class ProductService extends BaseService
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $repository;
    
    /**
     * ProductService constructor.
     * 
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
    
    /**
     * Create a new product with auto-generated slug
     * 
     * @param array $data
     * @return \App\Models\Product
     */
    public function createProduct(array $data)
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        return $this->repository->create($data);
    }
    
    /**
     * Update a product
     * 
     * @param int $id
     * @param array $data
     * @return \App\Models\Product
     */
    public function updateProduct(int $id, array $data)
    {
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        return $this->repository->update($id, $data);
    }
    
    /**
     * Get featured products
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedProducts(int $limit = 10)
    {
        return $this->repository->findFeatured($limit);
    }
    
    /**
     * Get products on sale
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductsOnSale()
    {
        return $this->repository->findOnSale();
    }
    
    /**
     * Search products
     * 
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchProducts(string $term)
    {
        return $this->repository->search($term);
    }
    
    /**
     * Get products by category
     * 
     * @param int $categoryId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductsByCategory(int $categoryId)
    {
        return $this->repository->findByCategory($categoryId);
    }
} 