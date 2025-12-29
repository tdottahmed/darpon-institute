<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierOrderHistory extends Model
{
    protected $fillable = [
        'phone',
        'data',
        'success_ratio',
        'total_orders',
        'cancel_orders',
        'last_checked_at',
    ];

    protected $casts = [
        'data' => 'array',
        'success_ratio' => 'decimal:2',
        'last_checked_at' => 'datetime',
    ];
}
