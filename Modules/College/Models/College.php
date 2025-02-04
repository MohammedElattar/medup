<?php

namespace Modules\College\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Speciality\Models\Speciality;
use App\Traits\HasTranslations;

class College extends Model
{
    use HasTranslations, PaginationTrait;

    protected $fillable = ['name'];

    protected $translatable = ['name'];

    public function specialities()
    {
        return $this->hasMany(Speciality::class);
    }
}
