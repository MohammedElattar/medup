<?php

namespace Modules\Library\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Pipeline;
use Modules\Collaborate\Models\Filters\CollaborateRelationFilter;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Library\Models\Filters\LibraryNewFilter;
use Modules\Library\Models\Filters\LibrarySuggestedFilter;

class LibraryBuilder extends Builder
{
    public function handleFilters(array $filters): LibraryBuilder
    {
        return Pipeline::send($this)
            ->through([
                fn($query, $next) => LibraryNewFilter::handle($query, $next, $filters),
                fn($query, $next) => LibrarySuggestedFilter::handle($query, $next, $filters),
                fn($query, $nex) => CollaborateRelationFilter::handle($query, $nex, $filters),
            ])->thenReturn();
    }

    public function withMinimalDetailsForPublic(): LibraryBuilder
    {
        return $this->select(['id', 'title', 'description', 'expert_id', 'price', 'speciality_id'])->withCover()->withMinimalExpertDetails()->withSpecialityDetails();
    }

    public function withDetailsForPublic(): LibraryBuilder
    {
        return $this->withCover()->withExpertDetails()->withSpecialityDetails();
    }

    public function withCover(): LibraryBuilder
    {
        return $this->with('cover');
    }

    public function withExpertDetails(): LibraryBuilder
    {
        return $this->with([
            'expert' => fn(ExpertBuilder|BelongsTo $b) => $b->withCityDetails()->withUserDetails()
        ]);
    }

    public function withMinimalExpertDetails(): LibraryBuilder
    {
        return $this->with([
            'expert:id,user_id',
            'expert.user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false)
        ]);
    }

    public function withSpecialityDetails(): LibraryBuilder
    {
        return $this->with('speciality.college:id,name');
    }
}
