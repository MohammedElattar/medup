<?php

namespace Modules\Payment\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use InvalidArgumentException;
use Modules\Payment\Exceptions\PaymentException;
use Stripe\Exception\InvalidRequestException;

class PaymentExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions): void
    {
        $exceptions->renderable(fn(PaymentException $e) => self::generalErrorResponse($e));
        $exceptions->renderable(function (InvalidRequestException|InvalidArgumentException $e) {
            $errorObject = StripeExceptionHelper::getErrorObject($e);

            return (new StripeExceptionHelper())->returnStripeError($errorObject);
        });
    }
}
