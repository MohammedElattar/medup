<?php

namespace Modules\Comment\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentBuilder extends Builder
{
    public function withDetails(): CommentBuilder
    {
        return $this->with([
            'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(additionalColumns: ['type']),
            'repliedUser' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false),
        ]);
    }
}
