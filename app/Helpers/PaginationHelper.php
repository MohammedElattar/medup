<?php

namespace App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PaginationHelper
{
    public static function paginationCountPerPage(): int
    {
        $count = request()->input('per_page') ?: 10;

        return ($count >= 4 && $count <= 100) ? $count : 10;
    }

    public static function paginateData(Builder $builder): LengthAwarePaginator
    {
        return $builder->paginate(static::paginationCountPerPage(), page: static::getCurrentPage());
    }

    public static function getCurrentPage()
    {
        return request()->input('page') ?: 1;
    }

    public static function getPaginationObject(LengthAwarePaginator $paginator): array
    {
        return [
            'currentPage' => $paginator->currentPage(),
            'total' => $paginator->total(),
            'perPage' => $paginator->perPage(),
            'lastPage' => $paginator->lastPage(),
        ];
    }
}
