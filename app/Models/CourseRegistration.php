<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
