<?php

namespace App\Actions;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

class CreateTenant
{
    /**
     * Create a new tenant with auto-incrementing ID
     *
     * @param array $data
     * @return Store
     */
    public function execute(array $data): Store
    {
        // Use a transaction to ensure data integrity
        DB::beginTransaction();
        
        try {
            // Create a new Store instance for the tenant
            $tenant = new Store();
            
            // Set the data
            $tenant->data = $data;
            
            // Save without setting an ID - let MySQL auto-increment it
            $tenant->save();
            
            DB::commit();
            
            return $tenant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 