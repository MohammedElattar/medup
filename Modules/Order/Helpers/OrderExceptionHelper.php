<?php

namespace Modules\Order\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\Order\Exceptions\OrderException;

class OrderExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn(OrderException $e) => self::generalErrorResponse($e));
    }
}
