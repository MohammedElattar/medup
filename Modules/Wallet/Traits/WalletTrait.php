<?php

namespace Modules\Wallet\Traits;

use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Wallet\Helpers\WalletHelper;

trait WalletTrait
{
    public function whereShowable($user, ?User $currentUser = null): static
    {
        $user = $user instanceof User ? $user : WalletHelper::getUser($user, new User);
        $currentUser = $currentUser ?: auth()->user();
        $userType = UserTypeEnum::getUserType($currentUser);

        switch ($userType) {
            case UserTypeEnum::VENDOR:
            case UserTypeEnum::NORMAL_USER:
            case UserTypeEnum::DELIVERY_MAN:
            case UserTypeEnum::MAINTENANCE:
                $this->whereUserId(auth()->id());
                break;

            case UserTypeEnum::ADMIN:
            case UserTypeEnum::ADMIN_EMPLOYEE:
                $this->whereUserId($user->id);
                break;
        }

        return $this;
    }
}
