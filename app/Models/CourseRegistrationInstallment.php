<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CourseRegistrationInstallment extends Model
{
    protected $fillable = [
        'course_registration_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'payment_method',
        'transaction_id',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function courseRegistration()
    {
        return $this->belongsTo(CourseRegistration::class);
    }

    /**
     * Check if installment is overdue
     */
    public function getIsOverdueAttribute()
    {
        return $this->status === 'pending' && $this->due_date < Carbon::today();
    }

    /**
     * Mark installment as paid
     */
    public function markAsPaid($paymentMethod = null, $transactionId = null, $notes = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => Carbon::today(),
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'notes' => $notes,
        ]);
    }
}
