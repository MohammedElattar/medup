<?php

namespace Modules\Expert\Models\Filters;

use Modules\Expert\Models\Builders\ExpertBuilder;

class TopExpertFilter
{
    public static function handle(array $filters, ExpertBuilder $query, $next)
    {
        if(isset($filters['only_top']) && $filters['only_top']) {
            $query
                ->where('top_start_time', '<=', now())
                ->where('top_end_time', '>', now());
        }

        return $next($query);
    }
}
