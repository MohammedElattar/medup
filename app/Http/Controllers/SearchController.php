<?php

namespace App\Http\Controllers;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    public static function searchForHandle(Builder $query, array $searchableKeys, $handle, array $translatedKeys = [], bool $orWhere = false): void
    {
        if (! is_null($handle)) {
            $query->where(fn (Builder $builder) => static::searchLogic($builder, $searchableKeys, $handle, $translatedKeys));
        }
    }

    private static function searchLogic(Builder $query, array $searchableKeys, $handle, array $translatedKeys = []): void
    {
        $isFirstKey = false;
        $table = $query->getModel()->getTable();

        foreach ($searchableKeys as $key) {
            if (in_array($key, $translatedKeys)) {
                foreach (TranslationHelper::$availableLocales as $locale) {
                    $hasVirtualColumn = isset($query->getModel()->virtualColumns) && in_array(TranslationHelper::generateVirtualColumnName($key, $locale), $query->getModel()->virtualColumns);

                    if (! $isFirstKey) {
                        if($hasVirtualColumn) {
                            $query->where("$table.".TranslationHelper::generateVirtualColumnName($key, $locale), $handle);
                        } else {
                            $query->where("$table."."$key->$locale", 'like', "%$handle%");
                        }

                        $isFirstKey = true;
                    } else {
                        if($hasVirtualColumn) {
                            $query->orWhere("$table.".TranslationHelper::generateVirtualColumnName($key, $locale), $handle);
                        } else {
                            $query->orWhere("$table."."$key->$locale", 'like', "%$handle%");
                        }
                    }
                }
            } else {
                if (! $isFirstKey) {
                    $query->where("$table.".$key, 'like', "%$handle%");
                    $isFirstKey = true;
                } else {
                    $query->orWhere("$table.".$key, 'like', "%$handle%");
                }
            }
        }
    }
}
