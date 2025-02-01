<?php

namespace Modules\Expert\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Modules\Expert\Models\Builders\ExpertBuilder;

class OrderByPremiumScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderByPremium();
    }
}
