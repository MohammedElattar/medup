<?php

namespace Modules\Country\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations, PaginationTrait;
    protected $fillable = ['name'];
    protected $translatable = ['name'];
}
