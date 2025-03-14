<?php

namespace Modules\Wallet\Listeners;

use Modules\Wallet\Entities\Wallet;

class CreateWalletListener
{
    public function __construct()
    {
        //
    }

    public function handle($event): void
    {
        Wallet::query()->create([
            'user_id' => $event->id,
            'balance' => 0,
        ]);
    }
}
