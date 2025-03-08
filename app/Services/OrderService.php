<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderService
 */
class OrderService extends BaseService
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $repository;
    
    /**
     * OrderService constructor.
     * 
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
    
    /**
     * Create a new order with items
     * 
     * @param array $orderData
     * @param array $items
     * @return Order
     */
    public function createOrder(array $orderData, array $items)
    {
        // Begin transaction
        return DB::transaction(function () use ($orderData, $items) {
            // Generate order number if not provided
            if (!isset($orderData['order_number'])) {
                $orderData['order_number'] = Order::generateOrderNumber();
            }
            
            // Calculate totals
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $orderData['subtotal'] = $subtotal;
            $orderData['total'] = $subtotal + 
                ($orderData['tax'] ?? 0) + 
                ($orderData['shipping'] ?? 0) - 
                ($orderData['discount'] ?? 0);
            
            // Create the order
            $order = $this->repository->create($orderData);
            
            // Create the order items
            foreach ($items as $item) {
                $item['order_id'] = $order->id;
                $item['subtotal'] = $item['price'] * $item['quantity'];
                $order->items()->create($item);
            }
            
            return $order->fresh(['items']);
        });
    }
    
    /**
     * Update order status
     * 
     * @param int $id
     * @param string $status
     * @return Order
     */
    public function updateOrderStatus(int $id, string $status)
    {
        return $this->repository->update($id, ['status' => $status]);
    }
    
    /**
     * Update payment status
     * 
     * @param int $id
     * @param string $paymentStatus
     * @return Order
     */
    public function updatePaymentStatus(int $id, string $paymentStatus)
    {
        return $this->repository->update($id, ['payment_status' => $paymentStatus]);
    }
    
    /**
     * Get order by order number
     * 
     * @param string $orderNumber
     * @return Order|null
     */
    public function getOrderByNumber(string $orderNumber)
    {
        return $this->repository->findByOrderNumber($orderNumber);
    }
    
    /**
     * Get orders for a customer
     * 
     * @param int $customerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomerOrders(int $customerId)
    {
        return $this->repository->findByCustomer($customerId);
    }
    
    /**
     * Get recent orders
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentOrders(int $limit = 10)
    {
        return $this->repository->getRecentOrders($limit);
    }
} 