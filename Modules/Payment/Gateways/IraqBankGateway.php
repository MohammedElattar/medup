<?php

namespace Modules\Payment\Gateways;

use Modules\Payment\Contracts\PaymentGateway;
use Modules\Payment\Factories\IraqBankPaymentMethod;

class IraqBankGateway implements PaymentGateway
{
    public function createPaymentMethod($paymentMethod)
    {
        return IraqBankPaymentMethod::make($paymentMethod);
    }
}