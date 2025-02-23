<?php

namespace Modules\Expert\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Pipeline;
use Modules\Expert\Models\Filters\ExpertDateFilter;
use Modules\Expert\Models\Filters\ExpertRelationFilter;
use Modules\Expert\Models\Filters\ExpertSearchFilter;
use Modules\Expert\Models\Filters\PremiumExpertFilter;
use Modules\Expert\Models\Filters\TopExpertFilter;

class ExpertBuilder extends Builder
{
    public function withBaseMinimalDetails(array $selectedColumns = ['*'], array $userSelectedColumns = [])
    {
        return $this
            ->select($selectedColumns)
            ->withTotalExperienceYears()
            ->withSkills()
            ->withSpecialityDetails()
            ->withUserDetails($userSelectedColumns)
            ->withCityDetails();
    }

    public function withMinimalPublicDetails(): ExpertBuilder
    {
        return $this
            ->withBaseMinimalDetails([
                'id', 'city_id', 'speciality_id', 'user_id', 'rating_average', 'is_premium',
            ]);
    }

    public function withDetailsForPublic()
    {
        return $this
            ->withBaseMinimalDetails(userSelectedColumns: ['created_at'])
            ->withExperiences()
            ->withCertificationDetails()
            ->withSocialContacts()
            ->withCv();
    }

    public function withDetailsForAdmin(): ExpertBuilder
    {
        return $this->withUserDetails(['status'])->withSpecialityDetails();
    }

    public function withProfileDetails()
    {
        return $this->withBaseMinimalDetails(userSelectedColumns: ['email', 'phone'])->withCv()->withSocialContacts();
    }

    public function withCv()
    {
        return $this->with('cv');
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

    public function withUserDetails(array $additionalColumns = []): ExpertBuilder
    {
        return $this->with([
            'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(additionalColumns: ['type', ...$additionalColumns])
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

    public function withExperiences()
    {
        return $this->with([
            'experiences' => fn(ExpertExperienceBuilder|HasMany $b) => $b->withMinimalDetailsForPublic()
        ]);
    }

    public function withCertificationDetails(): ExpertBuilder
    {
        return $this->with([
            'certification' => fn(CertificationBuilder|HasOne $b) => $b->withDetails(),
        ]);
    }

    public function withSocialContacts(): ExpertBuilder
    {
        return $this->with('socialContacts');
    }

    public function withTotalExperienceYears(): ExpertBuilder
    {
        return $this->withSum('experiences', 'experience_years');
    }
}
