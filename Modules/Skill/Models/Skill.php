<?php

namespace Modules\Skill\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasTranslations;
use App\Traits\Searchable;

class Skill extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, PaginationTrait, Searchable;

    protected $fillable = ['name', 'speciality_id'];

    protected $translatable = ['name'];

    public function icon()
    {
        return MediaHelper::mediaRelationship($this, 'skill_icon');
    }

    public function experts()
    {
        return $this->belongsToMany(Expert::class, 'expert_skill');
    }

    public function specialities(): BelongsToMany
    {
        return $this->belongsToMany(Speciality::class);
    }
}
