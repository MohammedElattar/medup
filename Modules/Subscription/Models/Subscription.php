<?php

namespace Modules\Subscription\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'starts_at',
        'ends_at',
        'paid',
        'expert_id',
    ];

    protected function casts()
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'paid' => 'boolean',
        ];
    }
}
