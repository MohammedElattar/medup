<?php

namespace Modules\Collaborate\Models\Filters;

class CollaboratePaidFilter
{
    public static function handle($query, $next, $filters)
    {
        if(isset($filters['paid'])) {
            $query->where('price', ['=', '<>'][(int)$filters['paid']], null);
        }

        return $next($query);
    }
}
