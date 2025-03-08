<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface OrderRepositoryInterface
 */
interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * Find orders by customer
     * 
     * @param int $customerId
     * @return Collection
     */
    public function findByCustomer(int $customerId): Collection;
    
    /**
     * Find orders by status
     * 
     * @param string $status
     * @return Collection
     */
    public function findByStatus(string $status): Collection;
    
    /**
     * Find orders by payment status
     * 
     * @param string $paymentStatus
     * @return Collection
     */
    public function findByPaymentStatus(string $paymentStatus): Collection;
    
    /**
     * Find orders created between two dates
     * 
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public function findByDateRange(string $startDate, string $endDate): Collection;
    
    /**
     * Find order by order number
     * 
     * @param string $orderNumber
     * @return \App\Models\Order|null
     */
    public function findByOrderNumber(string $orderNumber);
    
    /**
     * Get recent orders with specified limit
     * 
     * @param int $limit
     * @return Collection
     */
    public function getRecentOrders(int $limit = 10): Collection;
} 