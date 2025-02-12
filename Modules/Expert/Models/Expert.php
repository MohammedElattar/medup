<?php

namespace Modules\Expert\Models;

use App\Traits\PaginationTrait;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Expert\Models\Scopes\OrderByPremiumScope;
use Modules\Expert\Traits\ExpertRelations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Expert extends Model implements HasMedia
{
    use InteractsWithMedia, ExpertRelations, PaginationTrait, Searchable;

    protected $fillable = [
        'user_id',
        'city_id',
        'speciality_id',
        'rating_average',
        'is_premium',
        'graduation_year',
        'headline',
        'degree',
        'headline',
        'education',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new OrderByPremiumScope());
    }

    protected function casts()
    {
        return [
            'rating_average' => 'double',
            'is_premium' => 'boolean',
            'top_end_time' => 'datetime',
            'top_start_time' => 'datetime',
            'graduation_year' => 'integer',
            'experiences_sum_experience_years' => 'integer',
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new ExpertBuilder($query);
    }
}
