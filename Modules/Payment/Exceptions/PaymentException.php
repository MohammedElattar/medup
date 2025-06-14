<?php

namespace Modules\Payment\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentException extends Exception
{
    /**
     * @throws PaymentException
     */
    public static function unknownPaymentMethod()
    {
        throw new static(translate_word('unknown_payment_method'), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws PaymentException
     */
    public static function unknownPaymentGateway()
    {
        throw new static(translate_word('unknown_payment_gateway'), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws PaymentException
     */
    public static function notEnoughBalance()
    {
        throw new self(translate_word('not_enough_balance'), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @throws PaymentException
     */
    public static function notImplemented()
    {
        throw new self(translate_word('not_implemented_payment_method'), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
