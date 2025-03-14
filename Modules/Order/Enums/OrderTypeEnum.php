<?php

namespace Modules\Order\Enums;

enum OrderTypeEnum
{
    const COURSE = 'course';
    const LIBRARY = 'library';

    public static function toArray(): array
    {
        return [
            self::COURSE,
            self::LIBRARY,
        ];
    }
}
