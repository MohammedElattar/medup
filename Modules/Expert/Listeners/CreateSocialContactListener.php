<?php

namespace Modules\Expert\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Expert\Models\ExpertContact;

class CreateSocialContactListener
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
        ExpertContact::query()->create([
            'expert_id' => $event->id,
        ]);
    }
}
