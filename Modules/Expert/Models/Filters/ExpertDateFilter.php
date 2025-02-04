<?php

namespace Modules\Expert\Models\Filters;

use Modules\Expert\Models\Expert;

class ExpertDateFilter extends Expert
{
    public static function handle(array $filters, $builder, $next) {
        if(isset($filters['order_by_date'])) {
            $builder->orderBy('created_at', $filters['order_by_date']);
        }

        return $next($builder);
    }
}
