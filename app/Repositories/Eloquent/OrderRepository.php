<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderRepository
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Order::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByCustomer(int $customerId): Collection
    {
        return $this->model->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByPaymentStatus(string $paymentStatus): Collection
    {
        return $this->model->where('payment_status', $paymentStatus)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function findByOrderNumber(string $orderNumber)
    {
        return $this->model->where('order_number', $orderNumber)->first();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getRecentOrders(int $limit = 10): Collection
    {
        return $this->model->with(['customer', 'items'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
} 