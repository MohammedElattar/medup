<?php

namespace Modules\Wallet\Traits;

use App\Models\Builders\UserBuilder;
use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Wallet\Helpers\WalletHelper;

trait Transafable
{
    public function whereValidWalletReceiver($fromUser): static
    {
        User::query()->when(true, fn (UserBuilder $b) => $b->whereValidWalletSender())->findOrFail($fromUser);

        return $this
            ->where('status', true)
            ->whereIn('type', WalletHelper::publicTypes());
    }

    public function whereValidWalletSender(): static
    {
        return $this
            ->whereActive()
            ->whereIn('type', WalletHelper::publicTypes());
    }
}
