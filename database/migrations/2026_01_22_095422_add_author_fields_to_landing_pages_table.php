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
            // Author Section
            if (!Schema::hasColumn('landing_pages', 'author_badge')) {
                $table->string('author_badge')->nullable()->after('order_payment_note');
            }
            if (!Schema::hasColumn('landing_pages', 'author_name')) {
                $table->text('author_name')->nullable()->after('author_badge');
            }
            if (!Schema::hasColumn('landing_pages', 'author_title')) {
                $table->text('author_title')->nullable()->after('author_name');
            }
            if (!Schema::hasColumn('landing_pages', 'author_description')) {
                $table->longText('author_description')->nullable()->after('author_title');
            }
            if (!Schema::hasColumn('landing_pages', 'author_image')) {
                $table->string('author_image')->nullable()->after('author_description');
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
                'author_badge',
                'author_name',
                'author_title',
                'author_description',
                'author_image',
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
