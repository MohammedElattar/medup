<?php

namespace Modules\Comment\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Comment\Models\Comment;

trait CommentRelation
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
