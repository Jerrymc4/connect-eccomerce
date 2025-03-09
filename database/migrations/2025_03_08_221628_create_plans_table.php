<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('stripe_plan_id')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('billing_period')->default('monthly'); // monthly, yearly, etc.
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('max_products')->default(10);
            $table->integer('max_categories')->default(5);
            $table->integer('max_staff_accounts')->default(2);
            $table->json('features')->nullable(); // Additional features as JSON
            $table->boolean('has_custom_domain')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
