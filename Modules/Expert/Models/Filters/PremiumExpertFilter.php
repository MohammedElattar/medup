<?php

namespace Modules\Expert\Models\Filters;

class PremiumExpertFilter
{
    public static function handle(array $filters, $query, $next)
    {
        if(isset($filters['only_premium']))
        {
            $query->where('is_premium', $filters['only_premium']);
        }

        return $next($query);
    }
}
