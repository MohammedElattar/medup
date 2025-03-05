<?php

namespace Modules\Library\Models\Filters;

use Modules\Library\Models\Library;

class LibrarySuggestedFilter
{
    public static function handle($query, $next, array $filters)
    {
        if(isset($filters['suggested_based_id'])) {
            $item = Library::query()->findOrFail($filters['suggested_based_id']);

            $query
                ->where('id', '<>', $item->id)
                ->whereHas(
                    'speciality', fn($q) => $q->where(
                        'specialities.id',
                        $item
                            ->speciality()
                            ->select(['id'])
                            ->value('id')
                    )
                );
        }

        return $next($query);
    }
}
