<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Subscription\Services\SubscriptionService;

class SubscriptionController extends Controller
{
   use HttpResponse;

   public function __construct(private readonly SubscriptionService $subscriptionService)
   {
   }
}
