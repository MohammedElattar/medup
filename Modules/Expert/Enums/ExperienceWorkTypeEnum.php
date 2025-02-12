<?php

namespace Modules\Expert\Enums;

enum ExperienceWorkTypeEnum
{
    const FULL_TIME = 0;
    const PART_TIME = 1;
    const REMOTE = 2;

    public static function toArray()
    {
        return [self::FULL_TIME, self::PART_TIME, self::REMOTE];
    }
}
