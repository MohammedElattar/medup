<?php

namespace Modules\Payment\Contracts;

interface PaymentGateway
{
    public function createPaymentMethod($paymentMethod);
}
