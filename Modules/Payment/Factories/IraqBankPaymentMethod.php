<?php

namespace Modules\Payment\Factories;

use Modules\Payment\Contracts\PaymentMethod;
use Modules\Payment\Services\FirstIraqBankService;
use Modules\Payment\Strategies\PaymentStrategy;

class IraqBankPaymentMethod implements PaymentMethod
{
    public static function make($paymentMethod = null): PaymentStrategy
    {
        return new FirstIraqBankService();
    }
}