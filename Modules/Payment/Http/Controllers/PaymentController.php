<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Services\PaymentService;

class PaymentController extends Controller
{
    use HttpResponse;

    /**
     * @throws PaymentException
     */
    public function processWebhook(): void
    {
        $paymentId = request()->input('id');

        PaymentService::completePayment($paymentId);
    }
}
