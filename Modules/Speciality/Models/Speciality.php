<?php

namespace Modules\Speciality\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Speciality extends Model
{
    use HasTranslations, PaginationTrait;
    protected $fillable = ['name', 'college_id'];
    protected $translatable = ['name'];
}
