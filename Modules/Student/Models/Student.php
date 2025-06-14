<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Speciality\Models\Speciality;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'speciality_id',
    ];

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
}
