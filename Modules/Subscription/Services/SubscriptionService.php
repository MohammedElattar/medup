<?php

namespace Modules\Subscription\Services;

class SubscriptionService
{
    public function upgrade(array $data)
    {
        //TODO first check if the user already has a subscription or not
        //TODO if it has one, check it's end date and if it's not expired throw exception
        //TODO if it's expired, renew the subscription
        //TODO if it doesn't have a subscription, create a new one
    }
}
