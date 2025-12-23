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
        'payment_gateway_id',
        'transaction_id',
        'payment_screenshot',
        'payment_status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }
}
