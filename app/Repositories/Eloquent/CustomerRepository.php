<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomerRepository
 */
class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function model(): string
    {
        return Customer::class;
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
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getWithOrdersCount(): Collection
    {
        return $this->model->withCount('orders')->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTopCustomers(int $limit = 10): Collection
    {
        return $this->model->withCount('orders')
            ->withSum('orders', 'total')
            ->orderBy('orders_sum_total', 'desc')
            ->take($limit)
            ->get();
    }
    
    /**
     * {@inheritdoc}
     */
    public function search(string $term): Collection
    {
        return $this->model->where('first_name', 'like', "%{$term}%")
            ->orWhere('last_name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere(DB::raw("concat(first_name, ' ', last_name)"), 'like', "%{$term}%")
            ->get();
    }
} 