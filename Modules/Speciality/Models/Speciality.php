<?php

namespace Modules\Speciality\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\College\Models\College;
use App\Traits\HasTranslations;
use Modules\Expert\Models\Expert;
use Modules\Skill\Models\Skill;

class Speciality extends Model
{
    use HasTranslations, PaginationTrait;

    protected $fillable = ['name', 'college_id'];

    protected $translatable = ['name'];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function experts()
    {
        return $this->hasMany(Expert::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
