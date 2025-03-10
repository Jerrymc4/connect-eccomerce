<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:create 
                            {--name= : The store name}
                            {--domain= : The store domain}
                            {--email= : Store owner email}
                            {--with-sample-data : Create sample data for the store}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new store with its own database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get or prompt for store details
            $name = $this->option('name') ?: $this->ask('What is the store name?');
            
            // No longer using ID from slug - will use auto-incrementing ID
            
            // Ask for domain if not provided
            $domain = $this->option('domain') ?: $this->ask('What is the store domain?', Str::slug($name) . '.localhost');
            
            // Ask for email if not provided
            $email = $this->option('email') ?: $this->ask('What is the store owner email address?');
            
            $this->info('Creating store in the admin database and setting up store database...');
            $this->info("Name: $name");
            $this->info("Domain: $domain");
            $this->info("Email: $email");
            
            // Confirm creation
            if (!$this->confirm('Do you wish to continue?', true)) {
                $this->info('Store creation cancelled.');
                return 1;
            }
            
            // Begin database transaction for admin DB operations
            DB::connection('mysql')->beginTransaction();
            
            // Create the store record with auto-incrementing numeric ID
            $store = Store::createStore($name, $domain, $email);
            
            DB::connection('mysql')->commit();
            
            // Get the auto-generated ID
            $id = $store->id;
            $dbName = "store_{$id}";
            
            $this->info("Store created successfully in admin database!");
            $this->info("Store ID: {$id}");
            $this->info("Store Database: {$dbName}");
            $this->info("URL: https://{$domain}");
            
            // Manually create the store database with numeric ID
            $this->info("Creating database: {$dbName}");
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
            
            // Run migrations for the store database
            $this->info('Running migrations for the store database...');
            $this->call('stores:migrate', ['--stores' => $id]);
            
            // Create sample data if requested
            if ($this->option('with-sample-data')) {
                $this->info('Creating sample data for the store...');
                $this->call('stores:seed', [
                    '--stores' => $id,
                    '--class' => 'StoreSampleDataSeeder'
                ]);
            }
            
            $this->info('Store setup completed successfully!');
            $this->info("Access your store at: https://{$domain}");
            
            return 0;
        } catch (\Exception $e) {
            if (isset($store) && $store) {
                // If we get here, the store entity was created but something went wrong
                // We should clean up by deleting the store database if it exists
                $id = $store->id;
                $dbName = "store_{$id}";
                try {
                    DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
                    // Also delete the store record from the admin database
                    DB::connection('mysql')->table('stores')->where('id', $id)->delete();
                    DB::connection('mysql')->table('domains')->where('store_id', $id)->delete();
                } catch (\Exception $ex) {
                    $this->error('Error during cleanup: ' . $ex->getMessage());
                }
            }
            
            DB::connection('mysql')->rollBack();
            $this->error('Error creating store: ' . $e->getMessage());
            return 1;
        }
    }
}
