<?php

namespace App\Helpers;

use App\Http\Middleware\MustBeVerified;
use App\Http\Middleware\SetLocaleMiddleware;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Helpers\UserTypeHelper;
use Modules\Auth\Http\Middleware\EnabledMiddleware;

class GeneralHelper
{
    public static function adminMiddlewares(): array
    {
        return array_merge(self::getDefaultLoggedUserMiddlewares(), ['user_type_in:'.UserTypeEnum::ADMIN]);
    }

    public static function generalExpertMiddlewares(): array
    {
        return self::getDefaultLoggedUserMiddlewares(['user_type_in:'.UserTypeEnum::EXPERT.'|'.UserTypeEnum::EXPERT_LEARNER]);
    }

    public static function dashboardUserMiddlewares(): array
    {
        return self::getDefaultLoggedUserMiddlewares(['user_type_in:'.UserTypeEnum::ADMIN]);
    }

    public static function getDefaultLoggedUserMiddlewares($additionalMiddlewares = null): array
    {
        $defaultMiddlewares = [
            MustBeVerified::class,
            EnabledMiddleware::class,
            SetLocaleMiddleware::class,
        ];

        $middlewares = array_merge($defaultMiddlewares, $additionalMiddlewares ?? []);

        return [
            self::authMiddleware(),
            ...$middlewares,
        ];
    }

    public static function userTypeIn(array|string $types, bool $allowAdminAccess = true)
    {
        $types = is_string($types) ? $types : implode('|', $types);

        if($allowAdminAccess) {
            $types .= '|'.implode(UserTypeHelper::nonMobileTypes());
        }

        return 'user_type_in:'.$types;
    }

    public static function authMiddleware(): string
    {
        return 'auth:sanctum';
    }
}
