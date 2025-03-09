<?php

namespace Modules\Comment\Models\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Markable\Traits\Favorable;

class CommentBuilder extends Builder
{
    use Favorable;

    public function withDetails(): CommentBuilder
    {
        return $this->getFavorites()->withFavoritesCount()->with([
            'user' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(additionalColumns: ['type']),
            'repliedUser' => fn(UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false),
        ]);
    }
}
