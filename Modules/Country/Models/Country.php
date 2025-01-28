<?php

namespace Modules\Country\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Models\City;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations, PaginationTrait;

    protected $fillable = ['name'];

    protected $translatable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
