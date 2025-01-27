<?php

namespace Modules\Skill\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Skill extends Model implements HasMedia
{
    use HasTranslations, PaginationTrait, InteractsWithMedia;
    protected $fillable = ['name'];
    protected $translatable = ['name'];

    public function icon()
    {
        return MediaHelper::mediaRelationship($this, 'skill_icon');
    }
}
