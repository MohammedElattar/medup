<?php

namespace Modules\Library\Models\Filters;

use Modules\Library\Models\Library;

class LibrarySuggestedFilter
{
    public static function handle($query, $next, array $filters)
    {
        if(isset($filters['suggested_based_id'])) {
            $item = Library::query()->findOrFail($filters['suggested_based_id']);

            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $item->tags()->select('tags.id')));
        }

        return $next($query);
    }
}
