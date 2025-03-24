<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Subscription\Services\SubscriptionService;
use Modules\Subscription\Transformers\SubscriptionResource;

class SubscriptionController extends Controller
{
   use HttpResponse;

   public function __construct(private readonly SubscriptionService $subscriptionService)
   {
   }

   public function show()
   {
       $subscription = $this->subscriptionService->show();

       return $this->resourceResponse($subscription ? SubscriptionResource::make($subscription) : null);
   }

   public function renew()
   {
       $subscription = $this->subscriptionService->renew();

       return $this->createdResponse(SubscriptionResource::make($subscription), translate_word('subscription_created'));
   }

   public function cancel()
   {
       $this->subscriptionService->cancel();

       return $this->okResponse(message: translate_word('subscription_canceled'));
   }
}
