<?php

namespace Modules\Payment\Strategies;

interface PaymentStrategy {
    public function pay(int|float $amount, array $data = []);
    public function assertPaymentPaid($paymentId);
}
