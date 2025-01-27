<?php

namespace Modules\Auth\Helpers;

use Modules\Auth\Enums\UserTypeEnum;

class UserRelationHelper
{
    public static function loadUserRelations($user): void
    {
        $type = $user->type;

        switch ($type) {
            case UserTypeEnum::ADMIN:
                self::loadDashboardRelations($user);
                break;
        }
    }

    public static function loadDashboardRelations($user): void
    {

    }
}
