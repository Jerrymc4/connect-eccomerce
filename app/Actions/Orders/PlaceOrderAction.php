<?php

namespace App\Actions\Orders;

use App\Actions\Action;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * Class PlaceOrderAction
 * 
 * Action to place a new order in the system
 */
class PlaceOrderAction extends Action
{
    /**
     * @var OrderService
     */
    protected $orderService;
    
    /**
     * @var ProductService
     */
    protected $productService;
    
    /**
     * PlaceOrderAction constructor.
     * 
     * @param OrderService $orderService
     * @param ProductService $productService
     */
    public function __construct(OrderService $orderService, ProductService $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }
    
    /**
     * Execute the action to place a new order
     * 
     * @param array $orderData Order data including customer_id, shipping_address, billing_address, etc.
     * @param array $items Array of product items with product_id, quantity, etc.
     * @return \App\Models\Order
     * @throws InvalidArgumentException
     */
    public function execute(array $orderData = [], array $items = [])
    {
        // Validate order data
        $validator = Validator::make($orderData, [
            'customer_id' => 'required|exists:customers,id',
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        
        // Check if items array is empty
        if (empty($items)) {
            throw new InvalidArgumentException('Order must contain at least one item');
        }
        
        // Process order items
        $processedItems = [];
        
        foreach ($items as $item) {
            // Validate each item
            if (!isset($item['product_id']) || !isset($item['quantity'])) {
                throw new InvalidArgumentException('Each order item must have product_id and quantity');
            }
            
            // Get product details
            $product = $this->productService->find($item['product_id']);
            
            if (!$product) {
                throw new InvalidArgumentException("Product with ID {$item['product_id']} not found");
            }
            
            // Check if enough stock is available
            if ($product->stock < $item['quantity']) {
                throw new InvalidArgumentException("Not enough stock for product: {$product->name}");
            }
            
            // Prepare item data
            $processedItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => $item['quantity'],
                'options' => $item['options'] ?? null,
            ];
            
            // Decrease product stock
            $this->productService->update($product->id, [
                'stock' => $product->stock - $item['quantity']
            ]);
        }
        
        // Create the order
        return $this->orderService->createOrder($orderData, $processedItems);
    }
} 