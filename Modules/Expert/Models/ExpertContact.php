<?php

namespace Modules\Expert\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertContact extends Model
{
    protected $fillable = [
        'expert_id',
        'email',
        'twitter',
        'facebook',
        'linkedin',
    ];
}
