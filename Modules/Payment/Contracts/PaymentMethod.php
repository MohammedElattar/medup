<?php

namespace Modules\Payment\Contracts;

use Modules\Payment\Strategies\PaymentStrategy;

interface PaymentMethod
{
    public static function make($paymentMethod): PaymentStrategy;
}
