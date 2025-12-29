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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('product_type', ['course', 'book']); // Type of product
            $table->foreignId('product_id')->nullable(); // Can be course_id or book_id
            $table->text('hero_title')->nullable(); // Custom hero title
            $table->text('hero_subtitle')->nullable(); // Custom hero subtitle
            $table->string('hero_image')->nullable(); // Hero banner image
            $table->string('hero_video')->nullable(); // Hero video (URL or file path)
            $table->enum('hero_video_type', ['url', 'upload'])->nullable(); // Video type
            $table->longText('custom_description')->nullable(); // Rich text custom description
            $table->json('custom_images')->nullable(); // Array of custom images
            $table->json('custom_videos')->nullable(); // Array of custom videos (URLs or paths)
            $table->text('cta_text')->nullable(); // Call to action text
            $table->string('cta_button_text')->default('Enroll Now'); // CTA button text
            $table->boolean('status')->default(true); // Active/Inactive
            $table->text('meta_title')->nullable(); // SEO meta title
            $table->text('meta_description')->nullable(); // SEO meta description
            $table->string('meta_image')->nullable(); // SEO meta image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
