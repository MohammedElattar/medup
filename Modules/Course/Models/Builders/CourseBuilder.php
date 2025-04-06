<?php

namespace Modules\Course\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Pipeline;
use Modules\Collaborate\Models\Filters\CollaborateRelationFilter;
use Modules\Course\Models\Filters\CourseRecommendedFilter;
use Modules\Library\Models\Filters\LibrarySuggestedFilter;
use Modules\Library\Traits\CommonLibraryEloquent;
use Modules\Review\Traits\ReviewEloquentTrait;

class CourseBuilder extends Builder
{
    use CommonLibraryEloquent;

    private static array $baseColumns = [
        'id',
        'name',
        'description',
        'expert_id',
        'price',
        'speciality_id',
        'rating_average',
    ];

    public function handleFilters(array $filters): CourseBuilder
    {
        return Pipeline::send($this)
            ->through([
                fn($query, $nex) => CollaborateRelationFilter::handle($query, $nex, $filters),
                fn($query, $nex) => LibrarySuggestedFilter::handle($query, $nex, $filters),
                fn($query, $nex) => CourseRecommendedFilter::handle($query, $nex, $filters),
            ])
            ->thenReturn();
    }
    public function withMinimalDetailsForPublic(): CourseBuilder
    {
        return $this->select(self::$baseColumns)
            ->withCover()
            ->withMinimalExpertDetails()
            ->withSpecialityDetails();
    }

    public function withDetailsForPublic(): CourseBuilder
    {
        return $this
            ->select([...self::$baseColumns, 'link as public_link', 'created_at'])
            ->withCover()
            ->withExpertDetails()
            ->withPurchasedStatus()
            ->withSpecialityDetails();
    }

    public function withExpertDetails(): static
    {
        return $this->with([
            'expert:id,user_id,is_premium,city_id,speciality_id',
            'expert.user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false, ['type', 'status'])
        ]);
    }

    public function withMinimalDetailsForOrders()
    {
        return $this->select([...self::$baseColumns, 'link as public_link'])
            ->withCover()
            ->withExpertDetails()
            ->with(['order' => fn($q) => $q->where('user_id', auth()->id())]);
    }

    public function withPurchasedStatus() {
        return $this->with([
            'order' => fn($q) => $q->where('user_id', auth()->id()),
            'myReview',
        ]);
    }
}
