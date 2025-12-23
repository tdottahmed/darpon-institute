<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add foreign key if payment_gateways table exists and column exists
        if (Schema::hasTable('payment_gateways') && Schema::hasColumn('course_registrations', 'payment_gateway_id')) {
            // Check if foreign key already exists
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'course_registrations' 
                AND COLUMN_NAME = 'payment_gateway_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (empty($foreignKeys)) {
                Schema::table('course_registrations', function (Blueprint $table) {
                    $table->foreign('payment_gateway_id')
                        ->references('id')
                        ->on('payment_gateways')
                        ->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('course_registrations', 'payment_gateway_id')) {
            // Check if foreign key exists
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'course_registrations' 
                AND COLUMN_NAME = 'payment_gateway_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (!empty($foreignKeys)) {
                Schema::table('course_registrations', function (Blueprint $table) {
                    $table->dropForeign(['payment_gateway_id']);
                });
            }
        }
    }
};
