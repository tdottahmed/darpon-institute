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
        Schema::table('course_registrations', function (Blueprint $table) {
            // Check if columns already exist before adding
            if (!Schema::hasColumn('course_registrations', 'payment_gateway_id')) {
                $table->unsignedBigInteger('payment_gateway_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('course_registrations', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_gateway_id');
            }
            if (!Schema::hasColumn('course_registrations', 'payment_screenshot')) {
                $table->string('payment_screenshot')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('course_registrations', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_screenshot');
            }
        });

        // Add foreign key constraint separately only if payment_gateways table exists
        if (Schema::hasTable('payment_gateways')) {
            // Check if foreign key already exists
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'course_registrations' 
                AND COLUMN_NAME = 'payment_gateway_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (empty($foreignKeys) && Schema::hasColumn('course_registrations', 'payment_gateway_id')) {
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
        Schema::table('course_registrations', function (Blueprint $table) {
            // Drop foreign key first
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'course_registrations' 
                AND COLUMN_NAME = 'payment_gateway_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (!empty($foreignKeys)) {
                $table->dropForeign(['payment_gateway_id']);
            }

            // Drop columns if they exist
            if (Schema::hasColumn('course_registrations', 'payment_gateway_id')) {
                $table->dropColumn('payment_gateway_id');
            }
            if (Schema::hasColumn('course_registrations', 'transaction_id')) {
                $table->dropColumn('transaction_id');
            }
            if (Schema::hasColumn('course_registrations', 'payment_screenshot')) {
                $table->dropColumn('payment_screenshot');
            }
            if (Schema::hasColumn('course_registrations', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }
};
