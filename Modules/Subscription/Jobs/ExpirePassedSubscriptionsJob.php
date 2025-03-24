<?php

namespace Modules\Subscription\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Expert\Models\Expert;
use Modules\Subscription\Models\Subscription;

class ExpirePassedSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Subscription::query()
            ->whereNotNUll('ends_at')
            ->where('paid', true)
            ->where('ends_at', '<', now())->cursor()->each(function(Subscription $subscription){
            DB::transaction(function() use ($subscription){
                $subscription->update(['paid' => false]);
                Expert::query()->where('id', $subscription->expert_id)->update(['is_premium' => false]);
            });
        });
    }
}
