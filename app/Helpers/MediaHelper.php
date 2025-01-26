<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class MediaHelper
{
    public static array $defaultSelectedColumns = ['id', 'model_id', 'disk', 'file_name', 'mime_type'];

    public static function mediaRelationship(Model $model, string $collectionName = 'default', array $additionalSelectedColumns = [])
    {
        return $model
            ->media()
            ->where('collection_name', $collectionName)
            ->select(
                array_merge(
                    self::$defaultSelectedColumns,
                    $additionalSelectedColumns
                )
            );
    }

    public static function resetImage(HasMedia $model, string $collectionName)
    {
        $model->addMediaCollection($collectionName)->singleFile();
    }
}
