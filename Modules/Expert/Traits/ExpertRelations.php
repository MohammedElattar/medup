<?php

namespace Modules\Expert\Traits;

use App\Helpers\MediaHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\City\Models\City;
use Modules\Skill\Models\Skill;
use Modules\Speciality\Models\Speciality;

trait ExpertRelations
{
    public function cv()
    {
        return MediaHelper::mediaRelationship($this, 'expert_cv');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
