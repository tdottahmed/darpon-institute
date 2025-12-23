<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontendContent extends Model
{
    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'value' => 'array',
    ];
    //
}
