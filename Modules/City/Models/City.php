<?php

namespace Modules\City\Models;

use App\Traits\PaginationTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Country\Models\Country;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations, PaginationTrait;

    protected $fillable = ['name', 'country_id'];

    protected $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
