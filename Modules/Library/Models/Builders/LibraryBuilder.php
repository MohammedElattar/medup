<?php

namespace Modules\Library\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;
use Modules\Collaborate\Models\Filters\CollaborateRelationFilter;
use Modules\Library\Models\Filters\LibraryNewFilter;
use Modules\Library\Models\Filters\LibrarySuggestedFilter;
use Modules\Library\Traits\CommonLibraryEloquent;

class LibraryBuilder extends Builder
{
    use CommonLibraryEloquent;

    public function handleFilters(array $filters): LibraryBuilder
    {
        return Pipeline::send($this)
            ->through([
                fn($query, $next) => LibraryNewFilter::handle($query, $next, $filters),
                fn($query, $next) => LibrarySuggestedFilter::handle($query, $next, $filters),
                fn($query, $nex) => CollaborateRelationFilter::handle($query, $nex, $filters),
            ])->thenReturn();
    }

    public function withMinimalDetailsForPublic(array $additionalColumns = ['price']): LibraryBuilder
    {
        return $this
            ->select(['id', 'title', 'description', 'rating_average', 'expert_id', 'speciality_id', ...$additionalColumns])
            ->withCover()
            ->withMinimalExpertDetails()
            ->withSpecialityDetails()
            ->withPurchaseStatus();
    }

    public function withDetailsForPublic(): LibraryBuilder
    {
        return $this->withCover()->withExpertDetails()->withSpecialityDetails()->withPurchaseStatus();
    }

    public function withMinimalDetailsForOrders()
    {
        return $this->withMinimalDetailsForPublic([]);
    }

    public function withPurchaseStatus()
    {
        return $this->with([
            'order' => fn($q) => $q->where('orders.user_id', auth()->id()),
            'myReview',
        ]);
    }
}
