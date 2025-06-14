<?php

namespace Modules\Ad\Helpers;

use Modules\Role\Abstracts\PermissionDefinition;

class AdPermissionDefinition extends PermissionDefinition
{
    public static function permissions(): array
    {
        return [
            'ad' => self::generatePermissionsArray(),
        ];
    }

}
