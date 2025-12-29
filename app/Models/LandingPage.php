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
        'status',
        'meta_title',
        'meta_description',
        'meta_image',
    ];

    protected $casts = [
        'custom_images' => 'array',
        'custom_videos' => 'array',
        'status' => 'boolean',
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
}
