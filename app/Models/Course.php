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

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
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
}
