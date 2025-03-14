<?php

namespace Modules\Wallet\Helpers;

use App\Models\Builders\UserBuilder;
use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Exceptions\WalletException;

class WalletHelper
{
    public static function getUser(mixed $user, User $userModel)
    {
        $user = $user instanceof $userModel
            ? $user
            : $userModel::query()
                ->where('id', $user)
                ->firstOrFail();

        return $user;
    }

    /**
     * @throws WalletException
     */
    public static function getUserWallet(mixed $user, User $userModel)
    {
        $user = self::getUser($user, $userModel);

        $wallet = $user->wallet;

        if (! $wallet) {
            WalletException::userWalletNotExists();
        }

        return $wallet;
    }

    public static function getAdminWallet(Wallet $walletModel)
    {
        $admin = User::query()->when(true, fn(UserBuilder $b) => $b->whereIsAdmin())->first();
        $wallet = $walletModel->where('user_id', $admin->id)->first();

        return [
            $wallet,
            $admin,
        ];
    }

    public static function publicTypes()
    {
        return [
            UserTypeEnum::EXPERT,
            UserTypeEnum::TRAINEE,
            UserTypeEnum::STUDENT,
            UserTypeEnum::EXPERT_LEARNER,
        ];
    }

    public static function adminTypes()
    {
        return [
            UserTypeEnum::ADMIN,
        ];
    }
}
