<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Book extends Model implements Feedable
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

    /**
     * Convert the model to a feed item.
     */
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->short_description ?: strip_tags($this->long_description ?: ''))
            ->updated($this->updated_at)
            ->link(route('books.show', $this->slug))
            ->authorName($this->author ?: config('app.name'));
    }

    /**
     * Get all feed items.
     */
    public static function getFeedItems()
    {
        return static::where('status', true)
            ->latest()
            ->get();
    }
}
