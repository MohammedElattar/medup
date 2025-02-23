<?php

namespace Modules\Idea\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Pipeline;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Idea\Models\Filters\ideaPaidFilter;
use Modules\Idea\Models\Filters\IdeaRelationFilter;

class IdeaBuilder extends Builder
{
    public function withDetailsForPublic(): IdeaBuilder
    {
        return $this->withExpertDetails()->withSpecialityDetails();
    }

    public function withFilters(array $filters)
    {
        return Pipeline::send($this)
            ->through([
                fn($query, $next) => IdeaRelationFilter::handle($query, $next, $filters),
                fn($query, $next) => ideaPaidFilter::handle($query, $next, $filters),
            ])
            ->thenReturn();
    }

    public function withExpertDetails(): IdeaBuilder
    {
        return $this->with([
            'expert' => fn(ExpertBuilder|BelongsTo $b) => $b->withUserDetails()->select(['id', 'user_id'])
        ]);
    }

    public function withSpecialityDetails(): IdeaBuilder
    {
        return $this->with('speciality.college:id,name');
    }
}
