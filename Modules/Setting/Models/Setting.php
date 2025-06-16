<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'subscription_price',
        'mail_from',
        'mail_username',
        'mail_password',
        'mail_host',
        'mail_port',
        'mail_encryption',
        'mail_protocol',
        'stripe_secret_key',
    ];
}
