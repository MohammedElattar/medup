<?php

namespace Modules\Library\Models\Filters;

class LibraryNewFilter
{
    public static function handle($query, $next, array $filters)
    {
        if(isset($filters['only_new']) && $filters['only_new']) {
            $query->latest();
        }

        return $next($query);
    }
}
