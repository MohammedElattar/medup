<?php

namespace Modules\Markable\Traits;

use App\Models\Builders\UserBuilder;
use Closure;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasReactions
{
    public function withReactions(?Closure $closure = null, string $relationName = 'reactions')
    {
        return $this->with([
            $relationName => $closure ?: fn ($q) => $q,
        ]);
    }

    public function withReactionsDetails()
    {
        return $this->withReactions(fn (UserBuilder|MorphToMany $q) => $q->select(['users.id', 'users.first_name', 'users.middle_name', 'users.name'])->with('avatar'));
    }

    public function withLatestReactionDetails()
    {
        return $this->withReactions(
            fn (UserBuilder|MorphOne $q) => $q->with([
                'user' => fn ($q2) => $q2->select(['users.id', 'users.first_name', 'users.middle_name', 'users.name'])->with('avatar'),
            ]),
            'lastReaction'
        );
    }
}
