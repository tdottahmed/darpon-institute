<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseVariation extends Model
{
    protected $fillable = [
        'course_id',
        'name',
        'duration',
        'price',
        'discount',
        'discount_type',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Calculate the discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        if (!$this->price || $this->discount <= 0) {
            return $this->price;
        }

        if ($this->discount_type === 'flat') {
            return max(0, $this->price - $this->discount);
        }

        // Percentage discount
        return $this->price - ($this->price * $this->discount / 100);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
