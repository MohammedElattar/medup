<?php

namespace Modules\Subscription\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Setting\Helpers\SettingCacheHelper;
use Modules\Subscription\Models\Subscription;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Services\WalletService;

class SubscriptionService
{
    use ExpertSetter;

    public function show()
    {
        return $this->getExpert()->subscription;
    }

    public function cancel()
    {
        $subscription = $this->getExpert()->subscription;

        DB::transaction(function() use ($subscription){
            if($subscription) {
                $subscription->update([
                    'end_date' => now(),
                    'paid' => false,
                ]);

                $this->getExpert()->forceFill([
                    'is_premium' => false,
                ])->save();
            }
        });
    }

    public function renew()
    {
        $subscription = $this->getExpert()->subscription;

        DB::transaction(function() use (&$subscription){
            if(! $subscription) {
                $subscription = Subscription::query()->create([
                    'expert_id' => $this->getExpert()->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addMonth(),
                    'paid' => true,
                ]);
            }
            else {
                if($subscription->ends_at->isPast()) {
                    $subscription->update([
                        'starts_at' => now(),
                        'ends_at' => now()->addMonth(),
                        'paid' => true,
                    ]);
                } else {
                    $subscription->update([
                        'ends_at' => $subscription->ends_at->addMonth(),
                        'paid' => true,
                    ]);
                }
            }

            $this->getExpert()->forceFill([
                'is_premium' => true,
            ])->save();

            ( new WalletService(
                app(Wallet::class),
                app(User::class),
                app(TransactionService::class),
            ))->transferToAdmin(
                auth()->user(),
                SettingCacheHelper::getSubscriptionPrice(),
                ! $subscription ? 'Upgrade to premium' : 'Subscription renewal',
            );
        });

        return $subscription;
    }
}
