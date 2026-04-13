<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'author',
        'canonical_url',
    ];

    /**
     * Get the global SEO settings record.
     *
     * @return self
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate(['id' => 1]);
    }
}
