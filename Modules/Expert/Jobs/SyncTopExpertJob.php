<?php

namespace Modules\Expert\Jobs;

use App\Helpers\DateHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use Modules\Expert\Models\Expert;

class SyncTopExpertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $counter = 0;
        $chunk = [];
        $now = now();
        $startDate = Carbon::parse(Expert::query()->max('top_end_time')?: $now)->timezone('UTC');
        $endDate = $startDate->clone()->addHour();

        Expert::query()
            ->select('id')
            ->where(function(Builder $b) use ($now){
                $b->whereNull('top_end_time')
                    ->orWhere('top_end_time', '<', $now);
            })
            ->cursor()
            ->each(function(Expert $expert) use (&$counter, &$chunk, &$startDate, &$endDate) {
                $chunkSize = 16;
                $chunk[] = $expert->id;
                $counter++;

                if ($counter % $chunkSize === 0) {
                    $this->updateExperts($chunk, $startDate, $endDate);
                    $chunk = [];
                }
            });

        if (!empty($chunk)) {
            $this->updateExperts($chunk, $startDate, $endDate);
        }
    }

    /**
     * Update the experts in bulk.
     */
    private function updateExperts(array $chunk, &$startDate, &$endDate): void
    {
        Expert::query()
            ->whereIn('id', $chunk)
            ->update([
                'top_start_time' => $startDate->format(DateHelper::defaultDateTimeFormat()),
                'top_end_time' => $endDate->format(DateHelper::defaultDateTimeFormat()),
            ]);

        // Sync the dates for the next chunk
        $this->syncDates($startDate, $endDate);
    }

    /**
     * Sync the top start and end dates.
     */
    private function syncDates(&$startDate, &$endDate): void
    {
        $startDate = $endDate->clone();
        $endDate = $startDate->clone()->addHour();
    }
}
