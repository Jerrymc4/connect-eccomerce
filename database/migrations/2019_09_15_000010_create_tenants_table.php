<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            // Primary key
            $table->increments('id');
            
            // Store information
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active'); // active, inactive, suspended
            
            // Business details
            $table->string('business_name')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            
            // Address
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            
            // Basic branding (minimal info stored centrally)
            $table->string('logo_url')->nullable();
            
            // Subscription
            $table->string('plan')->default('free'); // free, basic, premium, enterprise
            $table->dateTime('subscription_ends_at')->nullable();
            
            // Owner details
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            
            // Standard fields
            $table->timestamps();
            $table->json('data')->nullable(); // Keep for compatibility with tenancy package
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
}
