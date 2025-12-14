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
        Schema::create('book_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('shipping_method'); // inside_dhaka, outside_dhaka
            $table->decimal('shipping_cost', 8, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('cod');
            $table->string('status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_orders');
    }
};
