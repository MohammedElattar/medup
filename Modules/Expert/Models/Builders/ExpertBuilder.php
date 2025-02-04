<?php

namespace Modules\Expert\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Pipeline;
use Modules\Expert\Models\Filters\ExpertDateFilter;
use Modules\Expert\Models\Filters\ExpertRelationFilter;
use Modules\Expert\Models\Filters\ExpertSearchFilter;
use Modules\Expert\Models\Filters\PremiumExpertFilter;
use Modules\Expert\Models\Filters\TopExpertFilter;

class ExpertBuilder extends Builder
{
    public function withMinimalPublicDetails()
    {
        return $this
            ->withSkills()
            ->withSpecialityDetails()
            ->withUserDetails()
            ->withCityDetails();
    }

    public function withSkills(): ExpertBuilder
    {
        return $this->with([
            'skills' => fn(BelongsToMany $q) => $q->select(['skills.id', 'name'])
        ]);
    }

    public function withSpecialityDetails(): ExpertBuilder
    {
        return $this->with([
            'speciality.college' => fn(BelongsTo $b) => $b->select(['id', 'name']),
        ]);
    }

    public function withCityDetails(): ExpertBuilder
    {
        return $this->with([
            'city.country' => fn(BelongsTo $b) => $b->select(['id', 'name']),
        ]);
    }

    public function withUserDetails(): ExpertBuilder
    {
        return $this->with([
            'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(additionalColumns: ['type'])
        ]);
    }

    public function handleFilters(array $filters)
    {
        self::setFilters($filters);

        return Pipeline::send($this)
            ->through([
                fn($builder, $next) => PremiumExpertFilter::handle($filters, $builder, $next),
                fn($builder, $next) => TopExpertFilter::handle($filters, $builder, $next),
                fn($builder, $next) => ExpertRelationFilter::handle($filters, $builder, $next),
                fn($builder, $next) => ExpertDateFilter::handle($filters, $builder, $next),
                fn($builder, $next) => ExpertSearchFilter::handle($filters, $builder, $next),
            ])
            ->thenReturn();
    }

    private function setFilters(array &$filters)
    {
        if (isset($filters['only_top']) && $filters['only_top']) {
            $filters['only_premium'] = true;
        }
    }

    public function orderByPremium(): ExpertBuilder
    {
        return $this->orderByRaw('CASE WHEN is_premium = true THEN 0 ELSE 1 END');
    }
}
