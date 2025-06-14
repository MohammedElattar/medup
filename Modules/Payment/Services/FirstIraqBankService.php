<?php

namespace Modules\Payment\Services;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Strategies\PaymentStrategy;
use Symfony\Component\HttpFoundation\Response;

class FirstIraqBankService implements PaymentStrategy
{
    private string $accessToken;
    private string $baseUrl;

    /**
     * @throws PaymentException
     */
    public function pay(float|int $amount, array $data = [])
    {
        $this->auth();

        try {
            $response = Http::withToken($this->accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($this->baseUrl . '/protected/v1/payments', [
                    'monetaryValue' => [
                        'amount' => "".round($amount),
                        'currency' => 'IQD',
                    ],
                    'statusCallbackUrl' => 'https://api.lampeonline.com/api/payments/webhook',
                    'description' => $data['description'] ?? 'order payment',
                    'category' => 'ECOMMERCE'
                ]);

            if($response->successful())
            {
                return $response->json();
            }

            throw new PaymentException($response->body(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            throw new PaymentException($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function auth()
    {
        $clientId = config('services.payment.iraq_bank.client_id');
        $clientSecret = config('services.payment.iraq_bank.client_secret');
        $this->baseUrl = config('services.payment.iraq_bank.base_url');

        $response = Http::asForm()
            ->post($this->baseUrl . '/auth/realms/fib-online-shop/protocol/openid-connect/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'client_credentials',
            ]);

        if($response->successful())
        {
            $data = $response->json();
            $this->accessToken = $data['access_token'];
        }

        else
        {
            throw new PaymentException('Failed to authenticate payment', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @throws PaymentException
     * @throws ConnectionException
     */
    public function assertPaymentPaid($paymentId): true
    {
        $this->auth();

        $response = Http::withToken($this->accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . "/protected/v1/payments/$paymentId/status");

        if ($response->successful() && $response->json('status') == 'PAID') {
            return true;
        }

        throw new PaymentException(translate_word($response->json()['status']), Response::HTTP_BAD_REQUEST);
    }
}