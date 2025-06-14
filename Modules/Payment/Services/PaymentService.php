<?php

namespace Modules\Payment\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Area\Services\AreaService;
use Modules\MainOrder\Entities\MainOrder;
use Modules\MainOrder\Services\MainOrder\ClientMainOrderService;
use Modules\Payment\Enums\PaymentMethodEnum;
use Modules\Payment\Events\PaymentFinishedEvent;
use Modules\Payment\Exceptions\PaymentException;
use Modules\Payment\Factories\PaymentFactory;
use Modules\Payment\Models\Payment;
use Modules\Vendor\Models\Vendor;
use Modules\Vendor\Services\VendorFeeService;

class PaymentService
{
    public static function storePayment(array $paymentData, Model $model): void
    {
        Payment::create([
            'payable_type' => get_class($model),
            'payable_id' => $model->getKey(),
            'payment_id' => $paymentData['paymentId'],
            'valid_till' => $paymentData['validUntil'],
        ]);
    }

    /**
     * @throws PaymentException
     */
    public static function completePayment($paymentId)
    {
        $payment = Payment::query()->where('payment_id', $paymentId)->firstOrFail();

        if($payment->valid_till->isPast())
        {
            throw new PaymentException('Payment is expired');
        }

        PaymentFactory::make(PaymentMethodEnum::ONLINE)->assertPaymentPaid($payment->payment_id);

        DB::transaction(function() use ($payment){
            switch($payment->payable_type)
            {
                case MainOrder::class:

                    $order = MainOrder::query()->withoutGlobalScopes()->findOrFail($payment->payable_id);

                    (new ClientMainOrderService(app(AreaService::class)))->setNormalUser(
                        $order->normalUser
                    )->pay($payment->payable_id);

                    break;

                case Vendor::class:
                    (new VendorFeeService())->setVendor(Vendor::query()->find($payment->payable_id))->processPayment();
                    break;
            }

            event(new PaymentFinishedEvent($payment->payment_id));

            $payment->delete();
        });
    }
}