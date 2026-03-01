<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'product_type',
        'product_id',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'hero_video',
        'hero_video_type',
        'custom_description',
        'custom_images',
        'custom_videos',
        'cta_text',
        'cta_button_text',
        'header_background_color',
        'status',
        'meta_title',
        'meta_description',
        'meta_image',
        // Hero Section
        'hero_main_image',
        'hero_english_title',
        'hero_bengali_title',
        'hero_preview_images',
        // PDF Preview Section
        'pdf_previews',
        // Book Details Section
        'book_details_title',
        'book_details_description',
        'book_details_specialties',
        'book_details_specialties_title',
        'book_details_specialties_description',
        'book_details_extraordinary',
        'book_details_extraordinary_title',
        'book_details_extraordinary_description',
        'book_details_students_love',
        'book_details_students_love_title',
        'book_details_students_love_description',
        // Features Section
        'features_list',
        'features_list_title',
        'features_list_description',
        'target_audience_list',
        'target_audience_list_title',
        'target_audience_list_description',
        'game_changer_title',
        'game_changer_points',
        'game_changer_description',
        'game_changer_conclusion',
        // Pricing Section
        'pricing_original_price',
        'pricing_offer_price',
        'pricing_description',
        'pricing_note',
        'pricing_regular_label',
        'pricing_offer_label',
        'pricing_book_label',
        // Order Section
        'order_section_title',
        'order_form_fields',
        'order_shipping_charge',
        'order_shipping_note',
        'order_payment_note',
        // Author Section
        'author_badge',
        'author_name',
        'author_title',
        'author_description',
        'author_image',
        // Section visibility
        'show_hero',
        'show_pdf_preview',
        'show_book_details',
        'show_features',
        'show_pricing',
        'show_order',
    ];

    protected $casts = [
        'custom_images' => 'array',
        'custom_videos' => 'array',
        'hero_preview_images' => 'array',
        'pdf_previews' => 'array',
        'book_details_specialties' => 'array',
        'book_details_extraordinary' => 'array',
        'book_details_students_love' => 'array',
        'features_list' => 'array',
        'target_audience_list' => 'array',
        'game_changer_points' => 'array',
        'order_form_fields' => 'array',
        'status' => 'boolean',
        'show_hero' => 'boolean',
        'show_pdf_preview' => 'boolean',
        'show_book_details' => 'boolean',
        'show_features' => 'boolean',
        'show_pricing' => 'boolean',
        'show_order' => 'boolean',
        'pricing_original_price' => 'decimal:2',
        'pricing_offer_price' => 'decimal:2',
        'order_shipping_charge' => 'decimal:2',
    ];

    /**
     * Get the product (course or book) associated with this landing page.
     */
    public function product()
    {
        if ($this->product_type === 'course') {
            return $this->belongsTo(Course::class, 'product_id');
        } else {
            return $this->belongsTo(Book::class, 'product_id');
        }
    }

    /**
     * Get the course if product type is course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'product_id');
    }

    /**
     * Get the book if product type is book.
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'product_id');
    }

    /**
     * Get default content for a new landing page
     */
    public static function getDefaultContent($product = null)
    {
        $isBook = $product instanceof Book;
        $isCourse = $product instanceof Course;

        $defaults = [
            'hero_english_title' => $product ? strtoupper($product->title) : 'TITLE',
            'hero_bengali_title' => $product ? ($isCourse ? 'কোর্সটির বর্ণনা এখানে লিখুন' : 'বইটির বর্ণনা এখানে লিখুন') : 'বর্ণনা এখানে লিখুন',
            'hero_preview_images' => [],
            'pdf_previews' => [],
            'book_details_title' => $isCourse ? 'কোর্সটি সম্পর্কে যা না জানলেই নয়' : 'বইটি সম্পর্কে যা না জানলেই নয়',
            'book_details_description' => $isCourse ? 'কোর্সটির বিস্তারিত বর্ণনা এখানে লিখুন।' : 'বইটির বিস্তারিত বর্ণনা এখানে লিখুন।',
            'book_details_specialties' => [
                ['title' => 'বিশেষত্ব ১', 'description' => 'বর্ণনা'],
                ['title' => 'বিশেষত্ব ২', 'description' => 'বর্ণনা'],
            ],
            'book_details_extraordinary' => [],
            'book_details_students_love' => [],
            'features_list' => [
                [
                    'title' => $isCourse ? 'কোর্সটির অসাধারণ কিছু বৈশিষ্ট্য' : 'বইটির অসাধারণ কিছু বৈশিষ্ট্য',
                    'items' => [
                        ['text' => 'বৈশিষ্ট্য ১', 'icon_color' => '#1a237e'],
                        ['text' => 'বৈশিষ্ট্য ২', 'icon_color' => '#1a237e'],
                    ]
                ]
            ],
            'target_audience_list' => [
                [
                    'title' => $isCourse ? 'কোর্সটি মূলত কাদের জন্য?' : 'বইটি মূলত কাদের জন্য?',
                    'items' => [
                        ['text' => 'দর্শক ১', 'icon_color' => '#1565c0'],
                        ['text' => 'দর্শক ২', 'icon_color' => '#1565c0'],
                    ]
                ]
            ],
            'game_changer_title' => $isCourse ? 'কেন এই কোর্স একটি গেম চেঞ্জার' : 'কেন এই বই একটি গেম চেঞ্জার',
            'game_changer_points' => [
                'বাস্তব কথোপকথন',
                'ব্যবহারিক অভিব্যক্তি',
                'স্পষ্ট উদাহরণ',
            ],
            'game_changer_conclusion' => 'ধাপে ধাপে এটি আপনাকে বেসিক থেকে অ্যাডভান্স-এ নিয়ে যায়।',
            'pricing_original_price' => $product ? $product->price : 0,
            'pricing_offer_price' => $product ? ($product->discounted_price ?? $product->price) : 0,
            'pricing_description' => 'বিশেষ অফারের বর্ণনা',
            'pricing_note' => $isCourse ? 'এনরোল করতে পেমেন্ট সম্পন্ন করুন' : 'অর্ডার করতে ১ টাকা অগ্রীম পেমেন্ট করতে হবে না',
            'order_section_title' => $isCourse ? 'Enroll Now' : 'Order Now',
            'order_form_fields' => ['Name', 'Phone', 'Address', 'Country/Region'], // Course might need fewer fields, but keeping consistent for now
            'order_shipping_charge' => $isBook ? 90 : 0,
            'order_shipping_note' => $isBook ? 'সারা বাংলাদেশে হোম ডেলিভারি চার্জ' : '',
            'order_payment_note' => $isBook ? 'Pay with cash upon delivery.' : 'Pay via bKash/Nagad/Rocket.',
        ];

        return $defaults;
    }

    /**
     * Initialize default content when creating a new landing page
     */
    public function initializeDefaults()
    {
        $product = $this->product;
        $defaults = self::getDefaultContent($product);

        foreach ($defaults as $key => $value) {
            if (is_null($this->$key)) {
                $this->$key = $value;
            }
        }
    }
}
