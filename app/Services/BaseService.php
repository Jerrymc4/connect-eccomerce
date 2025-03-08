<?php

namespace App\Services;

use App\Repositories\Contracts\RepositoryInterface;

/**
 * Class BaseService
 * 
 * Base implementation of service layer that works with repositories
 */
abstract class BaseService
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * BaseService constructor.
     * 
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     * 
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*'])
    {
        return $this->repository->all($columns);
    }

    /**
     * Find record by ID
     * 
     * @param int|string $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Create a new record
     * 
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update a record
     * 
     * @param int|string $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a record
     * 
     * @param int|string $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Get records with pagination
     * 
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*'])
    {
        return $this->repository->paginate($perPage, $columns);
    }
} 