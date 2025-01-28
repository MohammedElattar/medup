<?php

namespace Modules\Auth\Enums;

enum DegreeEnum
{
    const BACHELOR = 'bachelor';
    const MASTER = 'master';
    const PHD = 'phd';

    public static function toArray(): array
    {
        return [
            self::BACHELOR,
            self::MASTER,
            self::PHD,
        ];
    }
}
