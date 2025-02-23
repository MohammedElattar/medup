<?php

namespace Modules\Idea\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

class IdeaRelationFilter
{
    public static function handle(Builder $query, $next, array $filters)
    {
        info($filters);
        if(isset($filters['specialities'])) {
            $query->whereIntegerInRaw('speciality_id', $filters['specialities']);
        }

        return $next($query);
    }
}
