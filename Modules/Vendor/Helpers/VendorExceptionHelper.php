<?php

namespace Modules\Vendor\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\Vendor\Exceptions\VendorException;

class VendorExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn(VendorException $e) => self::generalErrorResponse($e));
    }
}