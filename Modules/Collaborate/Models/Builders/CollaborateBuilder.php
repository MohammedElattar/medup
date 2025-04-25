<?php

namespace Modules\Collaborate\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Pipeline;
use Modules\Collaborate\Models\Filters\CollaboratePaidFilter;
use Modules\Collaborate\Models\Filters\CollaborateRelationFilter;
use Modules\Expert\Models\Builders\ExpertBuilder;

class CollaborateBuilder extends Builder
{
    public function withDetailsForPublic(): CollaborateBuilder
    {
        return $this->withExpertDetails()->withSpecialityDetails()->withCommentsCount()->withComments();
    }

    public function withFilters(array $filters)
    {
        return Pipeline::send($this)
            ->through([
                fn($query, $next) => CollaborateRelationFilter::handle($query, $next, $filters),
                fn($query, $next) => CollaboratePaidFilter::handle($query, $next, $filters),
            ])
            ->thenReturn();
    }

    public function withExpertDetails(): CollaborateBuilder
    {
        return $this->with([
            'expert' => fn(ExpertBuilder|BelongsTo $b) => $b->withUserDetails()->select(['id', 'user_id'])
        ]);
    }

    public function withSpecialityDetails(): CollaborateBuilder
    {
        return $this->with('speciality.college:id,name');
    }

    public function withCommentsCount(): CollaborateBuilder
    {
        return $this->withCount('comments');
    }

    public function withComments() {
        return $this->with(['comments' => fn($q) => $q->withDetails()]);
    }
}
