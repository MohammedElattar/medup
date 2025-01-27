<?php

namespace Modules\Auth\Helpers;

use Modules\Auth\Enums\UserTypeEnum;

class UserTypeHelper
{
    public static function nonMobileTypes(): array
    {
        return [
            UserTypeEnum::ADMIN,
        ];
    }

    public static function mobileTypes(): array
    {
        return [
            UserTypeEnum::EXPERT,
            UserTypeEnum::STUDENT,
            UserTypeEnum::TRAINEE,
        ];
    }
}
