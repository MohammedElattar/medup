<?php

namespace Modules\Skill\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Models\Expert;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasTranslations;

class Skill extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia, PaginationTrait;

    protected $fillable = ['name'];

    protected $translatable = ['name'];

    public function icon()
    {
        return MediaHelper::mediaRelationship($this, 'skill_icon');
    }

    public function experts()
    {
        return $this->belongsToMany(Expert::class, 'expert_skill');
    }
}
