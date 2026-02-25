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
        Schema::table('landing_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('landing_pages', 'pricing_regular_label')) {
                $table->string('pricing_regular_label')->nullable()->after('pricing_note');
            }
            if (!Schema::hasColumn('landing_pages', 'pricing_offer_label')) {
                $table->string('pricing_offer_label')->nullable()->after('pricing_regular_label');
            }
            if (!Schema::hasColumn('landing_pages', 'pricing_book_label')) {
                $table->string('pricing_book_label')->nullable()->after('pricing_offer_label');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn(['pricing_regular_label', 'pricing_offer_label', 'pricing_book_label']);
        });
    }
};
