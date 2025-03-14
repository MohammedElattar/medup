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
            case UserTypeEnum::EXPERT:
            case UserTypeEnum::TRAINEE:
            case UserTypeEnum::STUDENT:
            case UserTypeEnum::EXPERT_LEARNER:
                $this->where('user_id', auth()->id());
                break;

            case UserTypeEnum::ADMIN:
                $this->where('user_id', $user->id);
                break;
        }

        return $this;
    }
}
