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
            if (!Schema::hasColumn('landing_pages', 'book_details_extraordinary_description')) {
                $table->longText('book_details_extraordinary_description')->nullable()->after('book_details_extraordinary');
            }
            if (!Schema::hasColumn('landing_pages', 'features_list_description')) {
                $table->longText('features_list_description')->nullable()->after('features_list');
            }
            if (!Schema::hasColumn('landing_pages', 'target_audience_list_description')) {
                $table->longText('target_audience_list_description')->nullable()->after('target_audience_list');
            }
            if (!Schema::hasColumn('landing_pages', 'game_changer_description')) {
                $table->longText('game_changer_description')->nullable()->after('game_changer_points');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $columnsToDrop = [
                'book_details_extraordinary_description',
                'features_list_description',
                'target_audience_list_description',
                'game_changer_description',
            ];

            $existingColumns = array_filter($columnsToDrop, function ($column) {
                return Schema::hasColumn('landing_pages', $column);
            });

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
