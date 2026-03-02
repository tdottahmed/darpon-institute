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
            if (!Schema::hasColumn('landing_pages', 'faq_section_title')) {
                $table->text('faq_section_title')->nullable()->after('author_image');
            }
            if (!Schema::hasColumn('landing_pages', 'faq_list')) {
                $table->json('faq_list')->nullable()->after('faq_section_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            if (Schema::hasColumn('landing_pages', 'faq_list')) {
                $table->dropColumn('faq_list');
            }
            if (Schema::hasColumn('landing_pages', 'faq_section_title')) {
                $table->dropColumn('faq_section_title');
            }
        });
    }
};
