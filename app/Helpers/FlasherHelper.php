<?php

namespace App\Helpers;

class FlasherHelper
{
    public static function success(string $message)
    {
        self::baseOptions()->success($message);
    }

    public static function error(string $message)
    {
        self::baseOptions()->error($message);
    }

    private static function baseOptions()
    {
        return flash()->options([
            'position' => 'bottom-center'
        ]);
    }
}
