<?php

namespace Modules\Auth\Helpers;

use Modules\Auth\Enums\UserTypeEnum;

class UserTypeHelper
{
    public static function nonMobileTypes(): array
    {
        return [
            UserTypeEnum::ADMIN,
            UserTypeEnum::ADMIN_EMPLOYEE,
            UserTypeEnum::INVENTORY_OWNER,
        ];
    }

    public static function mobileTypes(): array
    {
        return [
            UserTypeEnum::VENDOR,
        ];
    }
}
