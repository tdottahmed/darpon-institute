<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'tags',
        'long_description',
        'duration',
        'thumbnail',
        'preview_video',
        'status',
    ];

    protected $casts = [
        'tags' => 'array',
        'status' => 'boolean',
    ];
}
