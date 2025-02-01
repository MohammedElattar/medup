<?php

namespace Modules\Expert\Models\Filters;

use Modules\Expert\Http\Requests\ExpertFilterRequest;

class ExpertRelationFilter
{
    public static function handle(array $filters, $query, $next)
    {
        foreach(ExpertFilterRequest::$keys as $key => $relation) {
            if(isset($filters[$key])) {
                $query->whereHas($relation, fn($q) => $q->whereIntegerInRaw("$key.id", $filters[$key]));
            }
        }

        return $next($query);
    }
}
