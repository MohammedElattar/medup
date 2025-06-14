<?php

namespace Modules\Payment\Helpers;

use Modules\Payment\Enums\PaymentMethodEnum;

class PaymentHelper
{
    public static function getPaymentMethodFromData(array $data)
    {
        return $data['payment_details']['method'] ?? $data['method'];
    }

    public static function isCash(int $paymentMethod)
    {
        return $paymentMethod == PaymentMethodEnum::CASH_ON_DELIVERY;
    }
}
