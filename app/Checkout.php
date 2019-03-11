<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{    
    protected $fillable = [
        'document',
        'documentType',
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'description',
        'amount',
        'expiration',
        'requestId',
        'phone',
        'authorization',
        'franchise',
        'bank',
        'reason',
    ];

    protected $attributes = [
        'status' => 'PENDING'
    ];
}
