<?php

namespace Modules\Expert\Traits;

use App\Helpers\MediaHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\City\Models\City;
use Modules\Expert\Models\ExpertCertification;
use Modules\Expert\Models\ExpertContact;
use Modules\Expert\Models\ExpertExperience;
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

    public function experiences()
    {
        return $this->hasMany(ExpertExperience::class);
    }

    public function certification()
    {
        return $this->hasOne(ExpertCertification::class);
    }

    public function socialContacts(): HasOne
    {
        return $this->hasOne(ExpertContact::class, 'expert_id');
    }
}
