<?php

namespace Modules\Payment\Contracts;

interface DirectPaymentContract
{
    public function process(int|float $amount, array $paymentDetails);
}
