<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'price' => 0,
                'billing_period' => 'monthly',
                'description' => 'Perfect for getting started with e-commerce.',
                'is_featured' => false,
                'is_active' => true,
                'max_products' => 10,
                'max_categories' => 3,
                'max_staff_accounts' => 1,
                'has_custom_domain' => false,
                'features' => json_encode([
                    'Basic online store',
                    'Limited inventory management',
                    'Standard checkout',
                    'Email support',
                ]),
            ],
            [
                'name' => 'Starter',
                'price' => 29.99,
                'billing_period' => 'monthly',
                'description' => 'Great for small businesses ready to grow.',
                'is_featured' => true,
                'is_active' => true,
                'max_products' => 100,
                'max_categories' => 10,
                'max_staff_accounts' => 3,
                'has_custom_domain' => true,
                'features' => json_encode([
                    'Everything in Free',
                    'Advanced inventory management',
                    'Discount codes',
                    'Abandoned cart recovery',
                    'Priority email support',
                ]),
            ],
            [
                'name' => 'Business',
                'price' => 79.99,
                'billing_period' => 'monthly',
                'description' => 'Powerful tools for growing businesses.',
                'is_featured' => false,
                'is_active' => true,
                'max_products' => 500,
                'max_categories' => 30,
                'max_staff_accounts' => 10,
                'has_custom_domain' => true,
                'features' => json_encode([
                    'Everything in Starter',
                    'Professional reports',
                    'Gift cards',
                    'Advanced analytics',
                    'Phone support',
                ]),
            ],
            [
                'name' => 'Enterprise',
                'price' => 299.99,
                'billing_period' => 'monthly',
                'description' => 'For large-scale ecommerce operations.',
                'is_featured' => false,
                'is_active' => true,
                'max_products' => 10000,
                'max_categories' => 100,
                'max_staff_accounts' => 25,
                'has_custom_domain' => true,
                'features' => json_encode([
                    'Everything in Business',
                    'Unlimited products',
                    'Advanced B2B features',
                    'Custom integrations',
                    'Dedicated account manager',
                    '24/7 priority support',
                ]),
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create(array_merge(
                $plan, 
                ['slug' => Str::slug($plan['name'])]
            ));
        }
    }
}
