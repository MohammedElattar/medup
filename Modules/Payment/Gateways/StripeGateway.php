<?php

namespace Modules\Payment\Gateways;

use Modules\Payment\Contracts\PaymentGateway;
use Modules\Payment\Factories\StripePaymentMethod;

class StripeGateway implements PaymentGateway
{
    public function createPaymentMethod($paymentMethod)
    {
        return StripePaymentMethod::make($paymentMethod);
    }
}
