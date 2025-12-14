<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'review',
        'rating',
        'avatar',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
    ];
}
