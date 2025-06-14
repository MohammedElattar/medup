<?php

namespace Modules\Payment\Factories;

use Modules\Payment\Contracts\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Strategies\PaymentStrategy;
use Modules\Payment\Strategies\VirtualWalletStrategy;

class PaymobPaymentMethodFactory implements PaymentMethod
{
    /**
     * @throws PaymentException
     */
    public static function make($paymentMethod, array $details = []): PaymentStrategy
    {
        return match ($paymentMethod) {
            //            PaymentMethodEnum::CREDIT_CARD => new CreditCardStrategy(),
            //            PaymentMethodEnum::VIRTUAL_WALLET => new VirtualWalletStrategy(),
            default => PaymentException::unknownPaymentMethod(),
        };
    }
}
