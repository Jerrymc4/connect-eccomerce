<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;

class StoresSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:seed
                            {--stores= : The store IDs to seed (comma separated)}
                            {--all : Run the seeder for all stores}
                            {--class= : The class name of the root seeder}
                            {--force : Force the operation to run}
                            {--database= : The database connection to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed store databases with data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storeIds = $this->option('stores');
        $allStores = $this->option('all');
        
        if (!$storeIds && !$allStores) {
            $this->error('Please specify either --stores=ID1,ID2 or --all');
            return 1;
        }
        
        // Build the arguments array for the underlying command
        $arguments = [];
        
        // Map our options to the tenants:seed command options
        if ($storeIds) {
            $arguments['--tenants'] = explode(',', $storeIds);
        }
        
        // Pass through these options directly
        foreach (['class', 'force', 'database'] as $option) {
            if ($this->option($option)) {
                $arguments["--{$option}"] = $this->option($option);
            }
        }
        
        if ($allStores) {
            // If all stores are selected, list them first
            $stores = Store::all();
            
            if ($stores->isEmpty()) {
                $this->info('No stores found to seed.');
                return 0;
            }
            
            $this->info("Running seeder for all stores: {$stores->count()} found");
            
            // No need to specify --tenants when using tenants:seed without the option
            unset($arguments['--tenants']);
        } else {
            $storeIdArray = explode(',', $storeIds);
            $this->info("Running seeder for stores: " . implode(', ', $storeIdArray));
        }
        
        // Call the underlying tenants:seed command with our mapped arguments
        $this->call('tenants:seed', $arguments);
        
        $this->info('Store seeding completed.');
        
        return 0;
    }
}
