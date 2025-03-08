<?php

namespace App\Actions\Products;

use App\Actions\Action;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;

/**
 * Class CreateProductAction
 * 
 * Action to create a new product
 */
class CreateProductAction extends Action
{
    /**
     * @var ProductService
     */
    protected $productService;
    
    /**
     * CreateProductAction constructor.
     * 
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * Execute the action
     * 
     * @param array $data
     * @return \App\Models\Product
     * @throws \InvalidArgumentException
     */
    public function execute(array $data = [])
    {
        // Validate the data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:products,sku',
            'featured' => 'nullable|boolean',
            'status' => 'nullable|string|in:draft,published,archived',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
        
        // Set default values if not provided
        if (!isset($data['featured'])) {
            $data['featured'] = false;
        }
        
        if (!isset($data['status'])) {
            $data['status'] = 'draft';
        }
        
        // Create the product
        return $this->productService->createProduct($data);
    }
} 