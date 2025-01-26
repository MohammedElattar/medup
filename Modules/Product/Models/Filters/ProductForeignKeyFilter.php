<?php

namespace Modules\Product\Models\Filters;

class ProductForeignKeyFilter
{
    public static function handle($query, $next, array $filters)
    {
        if (isset($filters['inventory_owner_id'])) {
            $query->where('inventory_owner_id', $filters['inventory_owner_id']);
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $next($query);
    }
}
