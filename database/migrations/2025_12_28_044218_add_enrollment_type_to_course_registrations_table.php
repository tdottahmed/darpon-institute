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
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->enum('enrollment_type', ['online', 'offline'])->default('online')->after('user_id');
            $table->foreignId('course_variation_id')->nullable()->after('course_id')->constrained()->nullOnDelete();
            $table->boolean('is_installment_payment')->default(false)->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->dropForeign(['course_variation_id']);
            $table->dropColumn(['enrollment_type', 'course_variation_id', 'is_installment_payment']);
        });
    }
};
