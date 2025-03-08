<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;

class StoresMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:migrate
                            {--stores= : The store IDs to migrate (comma separated)}
                            {--all : Run migrations for all stores}
                            {--force : Force the operation to run}
                            {--path= : The path to the migrations files to be executed}
                            {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
                            {--pretend : Dump the SQL queries that would be run}
                            {--seed : Indicates if the seed task should be re-run}
                            {--step : Force the migrations to be run so they can be rolled back individually}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for store databases';

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
        
        // Map our options to the tenants:migrate command options
        if ($storeIds) {
            $arguments['--tenants'] = explode(',', $storeIds);
        }
        
        // Pass through these options directly
        foreach (['force', 'path', 'realpath', 'pretend', 'seed', 'step'] as $option) {
            if ($this->option($option) !== false) {
                $arguments["--{$option}"] = $this->option($option);
            }
        }
        
        if ($allStores) {
            // If all stores are selected, list them first
            $stores = Store::all();
            
            if ($stores->isEmpty()) {
                $this->info('No stores found to migrate.');
                return 0;
            }
            
            $this->info("Running migrations for all stores: {$stores->count()} found");
            
            // No need to specify --tenants when using tenants:migrate without the option
            unset($arguments['--tenants']);
        } else {
            $storeIdArray = explode(',', $storeIds);
            $this->info("Running migrations for stores: " . implode(', ', $storeIdArray));
        }
        
        // Call the underlying tenants:migrate command with our mapped arguments
        $this->call('tenants:migrate', $arguments);
        
        $this->info('Store migrations completed.');
        
        return 0;
    }
}
