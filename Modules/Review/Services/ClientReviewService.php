<?php

namespace Modules\Review\Services;

use Modules\Review\Entities\Builders\ReviewBuilder;
use Modules\Review\Entities\Review;

class ClientReviewService
{
    public function index()
    {
        return Review::query()
            ->when(true, fn (ReviewBuilder $b) => $b->withUserDetails()->handleFilters())
            ->get();
    }
}
