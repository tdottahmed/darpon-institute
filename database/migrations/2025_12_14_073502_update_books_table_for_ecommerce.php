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
        Schema::table('books', function (Blueprint $table) {
            // Remove PDF-related fields
            $table->dropColumn(['book_file', 'preview_pages']);

            // Remove unnecessary fields
            $table->dropColumn(['isbn', 'publisher', 'language', 'page_count', 'published_date']);

            // Add ecommerce fields
            $table->json('preview_images')->nullable()->after('cover_image'); // Array of preview image paths
            $table->decimal('discount', 5, 2)->nullable()->default(0)->after('price'); // Discount percentage
            $table->integer('stock_quantity')->default(0)->after('discount'); // Inventory quantity
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Restore PDF-related fields
            $table->string('book_file')->nullable();
            $table->json('preview_pages')->nullable();

            // Restore removed fields
            $table->string('isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable()->default('en');
            $table->integer('page_count')->nullable();
            $table->date('published_date')->nullable();

            // Remove ecommerce fields
            $table->dropColumn(['preview_images', 'discount', 'stock_quantity']);
        });
    }
};
