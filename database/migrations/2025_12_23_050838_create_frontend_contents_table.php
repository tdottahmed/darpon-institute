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
        Schema::create('frontend_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section')->index(); // e.g., 'hero', 'about'
            $table->string('key'); // e.g., 'title', 'bg_image'
            $table->longText('value')->nullable();
            $table->string('type')->default('text'); // 'text', 'image', 'textarea', 'richtext'
            $table->timestamps();

            $table->unique(['section', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frontend_contents');
    }
};
