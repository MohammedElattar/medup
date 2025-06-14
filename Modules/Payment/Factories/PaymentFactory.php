<?php

namespace Modules\Payment\Factories;

use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Gateways\IraqBankGateway;
use Modules\Payment\Gateways\StripeGateway;
use Modules\Payment\Strategies\PaymentStrategy;

class PaymentFactory
{
    /**
     * @throws PaymentException`
     */
    public static function make(int $paymentMethod = PaymentMethodEnum::CARD, ?int $paymentGateway = null): PaymentStrategy
    {
        $paymentGateway = is_null($paymentGateway) ? 'stripe' : $paymentGateway;

        $gateway = match ($paymentGateway) {
            'iraq-bank' => new IraqBankGateway(),
            'stripe' => new StripeGateway(),
            default => PaymentException::unknownPaymentGateway()
        };

        return $gateway->createPaymentMethod($paymentMethod);
    }
}
