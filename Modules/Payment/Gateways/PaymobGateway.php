<?php

namespace Modules\Payment\Gateways;

use Modules\Payment\Contracts\PaymentGateway;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Factories\PaymobPaymentMethodFactory;
use Modules\Payment\Strategies\PaymentStrategy;

class PaymobGateway implements PaymentGateway
{
    /**
     * @throws PaymentException
     */
    public function createPaymentMethod($paymentMethod): PaymentStrategy
    {
        return PaymobPaymentMethodFactory::make($paymentMethod);
    }
}
