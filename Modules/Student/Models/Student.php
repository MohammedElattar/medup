<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'speciality_id',
    ];
}
