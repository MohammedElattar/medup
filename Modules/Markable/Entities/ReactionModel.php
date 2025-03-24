<?php

namespace Modules\Markable\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Markable\Abstracts\Mark;
use Modules\Markable\Entities\Builders\ReactionModelBuilder;

class ReactionModel extends Mark
{
    use HasUuids;

    public $table = 'markable_reactions';

    public static function markableRelationName(): string
    {
        return 'reactions';
    }

    public function newEloquentBuilder($query)
    {
        return new ReactionModelBuilder($query);
    }
}
