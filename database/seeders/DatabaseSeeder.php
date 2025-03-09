<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed subscription plans
        $this->call(PlanSeeder::class);

        // User::factory(10)->create();

        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'user_type' => User::TYPE_ADMIN,
        ]);

        // Create a test store owner
        User::factory()->create([
            'name' => 'Store Owner',
            'email' => 'owner@example.com',
            'user_type' => User::TYPE_STORE_OWNER,
        ]);
    }
}
