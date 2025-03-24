<?php

namespace Modules\Markable\Traits;

use Modules\Markable\Entities\ReactionModel;

trait UserReactionRelations
{
    public function baseReactions()
    {
        return $this->reactions();
    }

    public function lastReaction()
    {
        return $this->morphOne(ReactionModel::class, 'markable')->latest('markable_reactions.created_at');
    }
}
