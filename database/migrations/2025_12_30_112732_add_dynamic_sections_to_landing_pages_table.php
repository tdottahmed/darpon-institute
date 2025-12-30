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
            // Hero Section
            if (!Schema::hasColumn('landing_pages', 'hero_main_image')) {
                $table->string('hero_main_image')->nullable()->after('hero_image');
            }
            if (!Schema::hasColumn('landing_pages', 'hero_english_title')) {
                $table->text('hero_english_title')->nullable()->after('hero_title');
            }
            if (!Schema::hasColumn('landing_pages', 'hero_bengali_title')) {
                $table->text('hero_bengali_title')->nullable()->after('hero_english_title');
            }
            if (!Schema::hasColumn('landing_pages', 'hero_preview_images')) {
                $table->json('hero_preview_images')->nullable()->after('hero_bengali_title');
            }

            // PDF Preview Section
            if (!Schema::hasColumn('landing_pages', 'pdf_previews')) {
                $table->json('pdf_previews')->nullable();
            }

            // Book Details Section
            if (!Schema::hasColumn('landing_pages', 'book_details_title')) {
                $table->text('book_details_title')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_description')) {
                $table->longText('book_details_description')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_specialties')) {
                $table->json('book_details_specialties')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_extraordinary')) {
                $table->json('book_details_extraordinary')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'book_details_students_love')) {
                $table->json('book_details_students_love')->nullable();
            }

            // Features Section
            if (!Schema::hasColumn('landing_pages', 'features_list')) {
                $table->json('features_list')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'target_audience_list')) {
                $table->json('target_audience_list')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'game_changer_title')) {
                $table->text('game_changer_title')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'game_changer_points')) {
                $table->json('game_changer_points')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'game_changer_conclusion')) {
                $table->text('game_changer_conclusion')->nullable();
            }

            // Pricing Section
            if (!Schema::hasColumn('landing_pages', 'pricing_original_price')) {
                $table->decimal('pricing_original_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'pricing_offer_price')) {
                $table->decimal('pricing_offer_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'pricing_description')) {
                $table->text('pricing_description')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'pricing_note')) {
                $table->text('pricing_note')->nullable();
            }

            // Order Section
            if (!Schema::hasColumn('landing_pages', 'order_section_title')) {
                $table->text('order_section_title')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'order_form_fields')) {
                $table->json('order_form_fields')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'order_shipping_charge')) {
                $table->decimal('order_shipping_charge', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'order_shipping_note')) {
                $table->text('order_shipping_note')->nullable();
            }
            if (!Schema::hasColumn('landing_pages', 'order_payment_note')) {
                $table->text('order_payment_note')->nullable();
            }

            // Section visibility toggles
            if (!Schema::hasColumn('landing_pages', 'show_hero')) {
                $table->boolean('show_hero')->default(true);
            }
            if (!Schema::hasColumn('landing_pages', 'show_pdf_preview')) {
                $table->boolean('show_pdf_preview')->default(true);
            }
            if (!Schema::hasColumn('landing_pages', 'show_book_details')) {
                $table->boolean('show_book_details')->default(true);
            }
            if (!Schema::hasColumn('landing_pages', 'show_features')) {
                $table->boolean('show_features')->default(true);
            }
            if (!Schema::hasColumn('landing_pages', 'show_pricing')) {
                $table->boolean('show_pricing')->default(true);
            }
            if (!Schema::hasColumn('landing_pages', 'show_order')) {
                $table->boolean('show_order')->default(true);
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
                'hero_main_image',
                'hero_english_title',
                'hero_bengali_title',
                'hero_preview_images',
                'pdf_previews',
                'book_details_title',
                'book_details_description',
                'book_details_specialties',
                'book_details_extraordinary',
                'book_details_students_love',
                'features_list',
                'target_audience_list',
                'game_changer_title',
                'game_changer_points',
                'game_changer_conclusion',
                'pricing_original_price',
                'pricing_offer_price',
                'pricing_description',
                'pricing_note',
                'order_section_title',
                'order_form_fields',
                'order_shipping_charge',
                'order_shipping_note',
                'order_payment_note',
                'show_hero',
                'show_pdf_preview',
                'show_book_details',
                'show_features',
                'show_pricing',
                'show_order',
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
