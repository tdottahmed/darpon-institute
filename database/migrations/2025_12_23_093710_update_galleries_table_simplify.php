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
        Schema::table('galleries', function (Blueprint $table) {
            // Drop columns that are no longer needed
            if (Schema::hasColumn('galleries', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('galleries', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('galleries', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('galleries', 'tags')) {
                $table->dropColumn('tags');
            }
            if (Schema::hasColumn('galleries', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('slug')->unique()->after('title');
            $table->text('description')->nullable()->after('slug');
            $table->json('tags')->nullable()->after('image');
            $table->string('category')->nullable()->after('tags');
        });
    }
};
