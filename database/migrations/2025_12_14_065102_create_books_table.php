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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->json('tags')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('book_file')->nullable(); // PDF file path
            $table->json('preview_pages')->nullable(); // Array of page numbers for preview [1, 2, 3]
            $table->decimal('price', 10, 2)->nullable();
            $table->date('published_date')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable()->default('en');
            $table->integer('page_count')->nullable();
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
