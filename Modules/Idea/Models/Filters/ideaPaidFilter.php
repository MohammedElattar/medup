<?php

namespace Modules\Idea\Models\Filters;

class ideaPaidFilter
{
    public static function handle($query, $next, $filters)
    {
        if(isset($filters['paid'])) {
            $query->where('price', ['=', '<>'][(int)$filters['paid']], null);
        }

        return $next($query);
    }
}
