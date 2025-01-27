<?php

namespace Modules\City\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations, PaginationTrait;

    protected $fillable = ['name', 'country_id'];

    protected $translatable = ['name'];
}
