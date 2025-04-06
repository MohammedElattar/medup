<?php

namespace Modules\Review\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Review\Entities\Review;

trait ReviewRelation
{
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function myReview()
    {
        return $this->morphOne(Review::class, 'reviewable')->where('user_id', auth()->id());
    }
}
