<?php

namespace Modules\Auth\Enums;

use App\Models\User;

enum UserTypeEnum
{
    const ADMIN = 0;

    const EXPERT = 1;

    const TRAINEE = 2;

    const STUDENT = 3;

    const EXPERT_LEARNER = 4;

    public static function availableTypes(): array
    {
        return [
            self::ADMIN,
            self::EXPERT,
            self::TRAINEE,
            self::STUDENT,
            self::EXPERT_LEARNER,
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
            self::EXPERT => 'expert',
            self::TRAINEE => 'trainee',
            self::STUDENT => 'student',
            self::EXPERT_LEARNER => 'expert_learner',
        ];
    }
}
