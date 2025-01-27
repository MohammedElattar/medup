<?php

namespace App\Helpers;

use App\Http\Middleware\MustBeVerified;
use App\Http\Middleware\SetLocaleMiddleware;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Http\Middleware\EnabledMiddleware;

class GeneralHelper
{
    public static function adminMiddlewares(): array
    {
        return array_merge(['auth', 'user_type_in:'.UserTypeEnum::ADMIN.'|', SetLocaleMiddleware::class]);
    }

    public static function dashboardUserMiddlewares(): array
    {
        return self::getDefaultLoggedUserMiddlewares(['user_type_in:'.UserTypeEnum::ADMIN]);
    }

    public static function getDefaultLoggedUserMiddlewares(array $additionalMiddlewares = [
        MustBeVerified::class,
        EnabledMiddleware::class,
    ]): array
    {
        return [
            self::authMiddleware(),
            ...$additionalMiddlewares,
        ];
    }

    public static function authMiddleware(): string
    {
        return 'auth:sanctum';
    }
}
