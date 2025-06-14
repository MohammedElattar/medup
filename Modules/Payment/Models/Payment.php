<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payable_type',
        'payable_id',
        'payment_id',
        'valid_till',
    ];

    protected $casts = [
        'valid_till' => 'datetime',
    ];
}
