<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRegistration extends Model
{
    protected $fillable = [
        'course_id',
        'course_variation_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'status',
        'enrollment_type',
        'payment_gateway_id',
        'transaction_id',
        'payment_screenshot',
        'payment_status',
        'is_installment_payment',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function courseVariation()
    {
        return $this->belongsTo(CourseVariation::class);
    }

    public function installments()
    {
        return $this->hasMany(CourseRegistrationInstallment::class)->orderBy('installment_number');
    }

    public function pendingInstallments()
    {
        return $this->installments()->where('status', 'pending');
    }

    public function paidInstallments()
    {
        return $this->installments()->where('status', 'paid');
    }
}
