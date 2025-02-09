<?php

namespace Modules\College\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\College\Services\PublicCollegeService;

class SyncCachedCollegesListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        cache()->forget('colleges_with_best_expert');
    }
}
