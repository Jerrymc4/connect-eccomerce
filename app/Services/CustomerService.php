<?php

namespace App\Services;

use App\Repositories\Contracts\CustomerRepositoryInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Class CustomerService
 */
class CustomerService extends BaseService
{
    /**
     * @var CustomerRepositoryInterface
     */
    protected $repository;
    
    /**
     * CustomerService constructor.
     * 
     * @param CustomerRepositoryInterface $repository
     */
    public function __construct(CustomerRepositoryInterface $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
    
    /**
     * Create a new customer with hashed password
     * 
     * @param array $data
     * @return \App\Models\Customer
     */
    public function createCustomer(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return $this->repository->create($data);
    }
    
    /**
     * Update a customer
     * 
     * @param int $id
     * @param array $data
     * @return \App\Models\Customer
     */
    public function updateCustomer(int $id, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        
        return $this->repository->update($id, $data);
    }
    
    /**
     * Find customer by email
     * 
     * @param string $email
     * @return \App\Models\Customer|null
     */
    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }
    
    /**
     * Get top customers
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTopCustomers(int $limit = 10)
    {
        return $this->repository->getTopCustomers($limit);
    }
    
    /**
     * Search customers
     * 
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchCustomers(string $term)
    {
        return $this->repository->search($term);
    }
    
    /**
     * Change customer status
     * 
     * @param int $id
     * @param string $status
     * @return \App\Models\Customer
     */
    public function changeStatus(int $id, string $status)
    {
        return $this->repository->update($id, ['status' => $status]);
    }
} 