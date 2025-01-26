<?php

namespace Modules\Vendor\Exceptions;

use App\Exceptions\BaseExceptionClass;
use Symfony\Component\HttpFoundation\Response;

class VendorException extends BaseExceptionClass
{
    /**
     * @throws VendorException
     */
    public static function notExists()
    {
        throw new self(translate_error_message('vendor', 'not_exists'), Response::HTTP_NOT_FOUND);
    }
}