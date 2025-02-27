<?php

namespace Modules\Collaborate\Models\Filters;

use Illuminate\Database\Eloquent\Builder;

class CollaborateRelationFilter
{
    public static function handle(Builder $query, $next, array $filters)
    {
        if(isset($filters['specialities'])) {
            $query->whereIntegerInRaw('speciality_id', $filters['specialities']);
        }

        return $next($query);
    }
}
