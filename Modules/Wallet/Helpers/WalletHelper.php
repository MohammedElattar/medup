<?php

namespace Modules\Wallet\Helpers;

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
            :
            (
                UserTypeEnum::getUserType() == UserTypeEnum::ADMIN_EMPLOYEE
                    ? $userModel::whereIsAdmin()->first()
                    :
                    $userModel::where('type', '<>', UserTypeEnum::ADMIN_EMPLOYEE)
                        ->whereId($user)
                        ->firstOrFail()
            );

        $userType = UserTypeEnum::getUserType($user);

        if ($userType == UserTypeEnum::ADMIN_EMPLOYEE) {
            $user = $userModel::query()->whereType(UserTypeEnum::ADMIN)->firstOrFail();
        }

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
        $admin = User::query()->whereIsAdmin()->first();
        $wallet = $walletModel->whereUserId($admin->id)->first();

        return [
            $wallet,
            $admin,
        ];
    }
}
