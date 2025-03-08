<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * 
 * Base repository interface that defines common methods for all repositories
 */
interface RepositoryInterface
{
    /**
     * Get all records
     * 
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;
    
    /**
     * Find record by ID
     * 
     * @param int|string $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, array $columns = ['*']): ?Model;
    
    /**
     * Find record by specific field value
     * 
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return Model|null
     */
    public function findBy(string $field, $value, array $columns = ['*']): ?Model;
    
    /**
     * Find multiple records by field value
     * 
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return Collection
     */
    public function findAllBy(string $field, $value, array $columns = ['*']): Collection;

    /**
     * Create a new record
     * 
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
    
    /**
     * Update a record
     * 
     * @param int|string $id
     * @param array $data
     * @return Model
     */
    public function update($id, array $data): Model;
    
    /**
     * Delete a record
     * 
     * @param int|string $id
     * @return bool
     */
    public function delete($id): bool;
    
    /**
     * Get records with pagination
     * 
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']);
} 