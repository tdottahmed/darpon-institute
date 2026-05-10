<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'focus_keyphrase_options',
        'is_active',
    ];

    protected $casts = [
        'focus_keyphrase_options' => 'array',
        'is_active' => 'boolean',
    ];
}
