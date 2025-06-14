<?php

namespace Modules\Payment\Strategies;

use Modules\Wallet\Exceptions\WalletException;

class VirtualWalletStrategy implements PaymentStrategy
{
    /**
     * @throws WalletException
     */
    public function pay(float|int $amount, array $data = [])
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if (! $wallet) {
            WalletException::userWalletNotExists();
        }

        if ($wallet->balance < $amount) {
            WalletException::notEnoughBalance($amount);
        }

        $wallet->decrement('balance', $amount);
    }
}
