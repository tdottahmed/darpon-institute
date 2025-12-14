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
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
