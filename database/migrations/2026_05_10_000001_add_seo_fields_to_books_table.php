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
            $table->json('focus_keyphrase_options')->nullable()->after('long_description');
            $table->string('seo_title')->nullable()->after('focus_keyphrase_options');
            $table->text('meta_description')->nullable()->after('seo_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['focus_keyphrase_options', 'seo_title', 'meta_description']);
        });
    }
};
