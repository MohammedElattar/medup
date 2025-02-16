<?php

namespace Modules\College\Models;

use App\Helpers\MediaHelper;
use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Models\Expert;
use Modules\Speciality\Models\Speciality;
use App\Traits\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class College extends Model implements HasMedia
{
    use HasTranslations, PaginationTrait, InteractsWithMedia, Searchable;

    protected $fillable = ['name', 'description'];

    protected $translatable = ['name', 'description'];

    public function specialities()
    {
        return $this->hasMany(Speciality::class);
    }

    public function experts()
    {
        return $this->hasManyThrough(Expert::class, Speciality::class);
    }

    public function icon()
    {
        return MediaHelper::mediaRelationship($this, 'college_logo');
    }
}
