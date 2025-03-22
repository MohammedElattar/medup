<?php

namespace Modules\Review\Services;

use Modules\Review\Entities\Builders\ReviewBuilder;
use Modules\Review\Entities\Review;

class AdminReviewService
{
    public function index()
    {
        return Review::query()
            ->when(true, fn (ReviewBuilder $b) => $b->withUserDetails()->handleFilters())
            ->paginatedCollection();
    }

    public function changePublic($status, $id)
    {
        Review::query()->findOrFail($id)->update(['public' => $status]);
    }
}
