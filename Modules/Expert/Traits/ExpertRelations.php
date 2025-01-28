<?php

namespace Modules\Expert\Traits;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Skill\Models\Skill;

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
}
