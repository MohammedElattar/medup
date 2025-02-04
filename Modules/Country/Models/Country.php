<?php

namespace Modules\Country\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\City\Models\City;
use App\Traits\HasTranslations;
use Modules\Expert\Models\Expert;

class Country extends Model
{
    use HasTranslations, PaginationTrait, Searchable;

    protected $fillable = ['name'];

    protected $translatable = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function experts(): HasManyThrough
    {
        return $this->hasManyThrough(Expert::class, City::class);
    }
}
