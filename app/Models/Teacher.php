<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'department',
        'description',
        'focus_keyphrase_options',
        'seo_title',
        'meta_description',
        'image_path',
        'order',
        'is_active',
    ];

    protected $casts = [
        'focus_keyphrase_options' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
