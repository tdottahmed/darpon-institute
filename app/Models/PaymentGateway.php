<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'type',
        'account_number',
        'account_name',
        'instructions',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get active payment gateways ordered by order field
     */
    public static function active()
    {
        return static::where('status', true)->orderBy('order')->orderBy('name');
    }

    /**
     * Get registrations using this payment gateway
     */
    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }
}
