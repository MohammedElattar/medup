<?php

namespace Modules\Wallet\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Wallet\Listeners\CreateWalletListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'eloquent.created: '. User::class => [
            CreateWalletListener::class,
        ],
    ];

    protected static $shouldDiscoverEvents = true;

    protected function configureEmailVerification(): void {}
}
