<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Course extends Model implements Feedable
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'tags',
        'long_description',
        'duration',
        'price',
        'discount',
        'discount_type',
        'thumbnail',
        'preview_video',
        'status',
        'offline_enrollment_enabled',
        'online_enrollment_enabled',
    ];

    protected $casts = [
        'tags' => 'array',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'offline_enrollment_enabled' => 'boolean',
        'online_enrollment_enabled' => 'boolean',
    ];

    /**
     * Calculate the discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        if (!$this->price || $this->discount <= 0) {
            return $this->price;
        }

        if ($this->discount_type === 'flat') {
            return max(0, $this->price - $this->discount);
        }

        // Percentage discount
        return $this->price - ($this->price * $this->discount / 100);
    }

    public function reviews()
    {
        return $this->hasMany(Testimonial::class, 'course_id')->where('status', true);
    }

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function isEnrolled($user)
    {
        if (!$user) {
            return false;
        }
        return $this->registrations()->where('user_id', $user->id)->exists();
    }

    public function variations()
    {
        return $this->hasMany(CourseVariation::class)->orderBy('sort_order');
    }

    public function activeVariations()
    {
        return $this->variations()->where('status', true);
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
            ->link(route('courses.show', $this->slug))
            ->authorName(config('app.name'));
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
