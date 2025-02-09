<?php

namespace Modules\College\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\College\Listeners\SyncCachedCollegesListener;
use Modules\College\Models\College;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        'eloquent.created: '. College::class => [
            SyncCachedCollegesListener::class,
        ],
        'eloquent.updated: '. College::class => [
            SyncCachedCollegesListener::class,
        ],
        'eloquent.deleted: '. College::class => [
            SyncCachedCollegesListener::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
