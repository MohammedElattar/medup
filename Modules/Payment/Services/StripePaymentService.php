<?php

namespace Modules\Payment\Services;

use Modules\Payment\Strategies\PaymentStrategy;

class StripePaymentService implements PaymentStrategy
{
    public function pay(int|float $amount, array $data = [])
    {
        $cardToken = $this->generateCreditCardToken($data);
        $this->chargeAmount($amount, $cardToken->id);
    }

    public function assertPaymentPaid($paymentId)
    {
        return true;
    }

    private function generateCreditCardToken(array $data)
    {
        return  \Stripe\Token::create([
            'card' => $data['payment_details']
        ]);
    }

    private function chargeAmount(int|float $amount, $tokenId, $description = 'Automatic charged amount')
    {
        return \Stripe\Charge::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'source' => $tokenId,
            'description' => $description,
        ]);
    }
}
