<?php

namespace Modules\Auth\Enums;

use App\Models\User;

enum UserTypeEnum
{
    const ADMIN = 0;

    const INVENTORY_OWNER = 1;

    const ADMIN_EMPLOYEE = 2;

    const VENDOR = 3;

    public static function availableTypes(): array
    {
        return [
            self::ADMIN,
            self::INVENTORY_OWNER,
            self::VENDOR,
        ];
    }

    public static function getUserType(?User $user = null)
    {
        $user = ! is_null($user) ? $user : auth()->user();

        return $user?->type;
    }

    public static function alphaTypes(): array
    {
        return [
            self::ADMIN => 'admin',
            self::INVENTORY_OWNER => 'inventory_owner',
            self::VENDOR => 'vendor',
        ];
    }
}
