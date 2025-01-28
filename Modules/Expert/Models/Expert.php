<?php

namespace Modules\Expert\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Traits\ExpertRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Expert extends Model implements HasMedia
{
    use InteractsWithMedia, ExpertRelations;

    protected $fillable = [
        'user_id',
        'city_id',
        'speciality_id',
    ];
}
