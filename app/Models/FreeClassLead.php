<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeClassLead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'status',
        'notes',
        'ip_address',
    ];
}
