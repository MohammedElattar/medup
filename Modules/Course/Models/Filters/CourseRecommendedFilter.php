<?php

namespace Modules\Course\Models\Filters;

class CourseRecommendedFilter
{
    public static function handle($query, $next, $filters)
    {
        if(isset($filters['recommended'])) {
            $query->latest('rating_average');
        }

        return $next($query);
    }
}
