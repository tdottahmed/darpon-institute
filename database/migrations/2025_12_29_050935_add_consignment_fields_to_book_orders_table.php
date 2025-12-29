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
        Schema::table('book_orders', function (Blueprint $table) {
            $table->string('consignment_id')->nullable()->after('status');
            $table->string('tracking_code')->nullable()->after('consignment_id');
            $table->timestamp('consignment_created_at')->nullable()->after('tracking_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropColumn(['consignment_id', 'tracking_code', 'consignment_created_at']);
        });
    }
};
