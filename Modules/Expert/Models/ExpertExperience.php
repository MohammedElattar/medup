<?php

namespace Modules\Expert\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Models\City;
use Modules\Expert\Models\Builders\ExpertExperienceBuilder;

class ExpertExperience extends Model
{
    protected $fillable = [
        'expert_id',
        'job_title',
        'hospital_name',
        'start_date',
        'end_date',
        'work_type',
        'city_id',
        'content',
        'city_id',
        'experience_years',
    ];

    protected $casts = [
        'experience_years' => 'integer',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function newEloquentBuilder($query)
    {
        return new ExpertExperienceBuilder($query);
    }
}
