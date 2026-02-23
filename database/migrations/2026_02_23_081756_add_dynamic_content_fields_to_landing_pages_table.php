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
            if (!Schema::hasColumn('landing_pages', 'book_details_specialties_title')) {
                $table->text('book_details_specialties_title')->nullable()->after('book_details_specialties');
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_specialties_description')) {
                $table->longText('book_details_specialties_description')->nullable()->after('book_details_specialties_title');
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_students_love_title')) {
                $table->text('book_details_students_love_title')->nullable()->after('book_details_students_love');
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_students_love_description')) {
                $table->longText('book_details_students_love_description')->nullable()->after('book_details_students_love_title');
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
                'book_details_specialties_title',
                'book_details_specialties_description',
                'book_details_students_love_title',
                'book_details_students_love_description',
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
