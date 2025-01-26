<?php

namespace Modules\Wallet\Traits;

use App\Models\Builders\UserBuilder;
use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;

trait Transafable
{
    public function whereValidWalletReceiver($fromUser): static
    {
        User::query()->when(true, fn (UserBuilder $b) => $b->whereValidWalletSender())->findOrFail($fromUser);

        return $this
            ->whereActive()
            ->whereIn('type', [
                UserTypeEnum::NORMAL_USER,
                UserTypeEnum::VENDOR,
                UserTypeEnum::DELIVERY_MAN,
                UserTypeEnum::MAINTENANCE,
            ]);
    }

    public function whereValidWalletSender(): static
    {
        return $this
            ->whereActive()
            ->whereIn('type', [
                UserTypeEnum::ADMIN,
                UserTypeEnum::ADMIN_EMPLOYEE,
            ]);
    }
}
