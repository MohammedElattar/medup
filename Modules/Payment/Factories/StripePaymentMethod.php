<?php

namespace Modules\Payment\Factories;

use Modules\Payment\Contracts\PaymentMethod;
use Modules\Payment\Services\StripePaymentService;
use Modules\Payment\Strategies\PaymentStrategy;

class StripePaymentMethod implements PaymentMethod
{
    public static function make($paymentMethod = null): PaymentStrategy
    {
        return new StripePaymentService();
    }
}
