<?php

namespace Modules\City\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Country\Models\Country;
use App\Traits\HasTranslations;
use Modules\Expert\Models\Expert;

class City extends Model
{
    use HasTranslations, PaginationTrait, Searchable;

    protected $fillable = ['name', 'country_id'];

    protected $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function experts()
    {
        return $this->hasMany(Expert::class);
    }
}
