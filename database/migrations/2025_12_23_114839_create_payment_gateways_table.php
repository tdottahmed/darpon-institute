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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Bkash", "Nagad", "Rocket", "Bank Transfer"
            $table->string('type'); // 'bkash', 'nagad', 'rocket', 'bank'
            $table->string('account_number')->nullable(); // Phone number or account number
            $table->string('account_name')->nullable(); // Account holder name
            $table->text('instructions')->nullable(); // Payment instructions for users
            $table->integer('order')->default(0); // For sorting
            $table->boolean('status')->default(true); // Active/Inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
