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
        Schema::table('courses', function (Blueprint $table) {
            $table->json('focus_keyphrase_options')->nullable()->after('long_description');
            $table->string('seo_title')->nullable()->after('focus_keyphrase_options');
            $table->text('meta_description')->nullable()->after('seo_title');
        });

        Schema::table('custom_pages', function (Blueprint $table) {
            $table->json('focus_keyphrase_options')->nullable()->after('meta_description');
        });

        Schema::table('landing_pages', function (Blueprint $table) {
            $table->json('focus_keyphrase_options')->nullable()->after('meta_image');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->json('focus_keyphrase_options')->nullable()->after('description');
            $table->string('seo_title')->nullable()->after('focus_keyphrase_options');
            $table->text('meta_description')->nullable()->after('seo_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['focus_keyphrase_options', 'seo_title', 'meta_description']);
        });

        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropColumn('focus_keyphrase_options');
        });

        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn('focus_keyphrase_options');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['focus_keyphrase_options', 'seo_title', 'meta_description']);
        });
    }
};
