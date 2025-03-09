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
        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->string('subscription_status')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('setup_status')->default('incomplete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn('plan_id');
            $table->dropColumn('subscription_status');
            $table->dropColumn('subscription_ends_at');
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('stripe_subscription_id');
            $table->dropColumn('setup_status');
        });
    }
};
