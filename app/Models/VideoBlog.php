<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class VideoBlog extends Model implements Feedable
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'long_description',
        'video_type',
        'video_file',
        'video_url',
        'thumbnail',
        'tags',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
        'status' => 'boolean',
    ];

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
            ->link(route('video_blogs.show', $this->slug))
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
