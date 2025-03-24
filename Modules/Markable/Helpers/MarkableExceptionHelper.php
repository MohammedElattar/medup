<?php

namespace Modules\Markable\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\Markable\Exceptions\InvalidMarkableInstanceException;
use Modules\Markable\Exceptions\InvalidMarkInstanceException;
use Modules\Markable\Exceptions\InvalidMarkValueException;

class MarkableExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn (InvalidMarkableInstanceException $e) => self::generalErrorResponse($e));
        $exceptions->renderable(fn (InvalidMarkInstanceException $e) => self::generalErrorResponse($e));
        $exceptions->renderable(fn (InvalidMarkValueException $e) => self::generalErrorResponse($e));
    }
}
