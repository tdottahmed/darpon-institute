<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'short_description',
        'long_description',
        'tags',
        'cover_image',
        'preview_images',
        'price',
        'discount',
        'stock_quantity',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
        'preview_images' => 'array',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Calculate the discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->price && $this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }
}
