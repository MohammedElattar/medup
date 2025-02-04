<?php

namespace Modules\Expert\Models\Filters;

class ExpertSearchFilter
{
    public static function handle(array $filters, $builder, $next)
    {
        if(request()->has('handle')) {
            $builder->where(function($query){
               $query->searchByRelation('user', ['name']);
            });
        }

        if(isset($filters['city'])) {
            $builder->where(function($query) use ($filters){
               $query->searchByRelation(
                   'city',
                   ['name'],
                   ['name'],
                   handleKeyName: 'city',
               )->searchByRelation(
                   'city.country',
                   ['name'],
                   ['name'],
                   orWhere: true,
                   handleKeyName: 'city',
               );
            });
        }

        return $next($builder);
    }
}
