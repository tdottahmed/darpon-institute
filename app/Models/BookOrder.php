<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookOrder extends Model
{
    protected $fillable = [
        'book_id',
        'quantity',
        'name',
        'email',
        'phone',
        'address',
        'shipping_method',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'status',
        'note',
        'consignment_id',
        'tracking_code',
        'consignment_created_at',
    ];

    protected $casts = [
        'consignment_created_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
