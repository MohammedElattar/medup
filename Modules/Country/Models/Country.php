<?php

namespace Modules\Country\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\City\Models\City;
use App\Traits\HasTranslations;

class Country extends Model
{
    use HasTranslations, PaginationTrait, Searchable;

    protected $fillable = ['name'];

    protected $translatable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
