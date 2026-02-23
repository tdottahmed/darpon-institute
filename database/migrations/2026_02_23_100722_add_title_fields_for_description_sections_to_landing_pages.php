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
            if (!Schema::hasColumn('landing_pages', 'book_details_extraordinary_title')) {
                $table->text('book_details_extraordinary_title')->nullable()->after('book_details_extraordinary');
            }
            if (!Schema::hasColumn('landing_pages', 'features_list_title')) {
                $table->text('features_list_title')->nullable()->after('features_list');
            }
            if (!Schema::hasColumn('landing_pages', 'target_audience_list_title')) {
                $table->text('target_audience_list_title')->nullable()->after('target_audience_list');
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
                'book_details_extraordinary_title',
                'features_list_title',
                'target_audience_list_title',
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
