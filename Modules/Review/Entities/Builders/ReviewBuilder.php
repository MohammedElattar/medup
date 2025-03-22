<?php

namespace Modules\Review\Entities\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Expert\Models\Expert;
use Modules\Review\Entities\Review;

class ReviewBuilder extends Builder
{
    public function withUserDetails(): ReviewBuilder
    {
        return $this->with([
            'user' => fn (UserBuilder|BelongsTo $builder) => $builder->withMinimalDetails(excludeColumns: ['phone', 'email', 'status']),
        ]);
    }

    public function handleFilters()
    {
        $expertId = request()->input('expert_id');
        $this
            ->with([
                'user' => fn(UserBuilder|BelongsTo $query) => $query->withMinimalDetails(),
            ])
            ->whereHasMorph('reviewable', [Expert::class], fn($q) => $q->where('experts.id', $expertId))
            ->searchByRelation('user', ['name']);

        return $this;
    }
}
