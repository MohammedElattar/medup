<?php

namespace Modules\Expert\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\Expert\Exceptions\ExpertException;

class ExpertExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn(ExpertException $e) => self::generalErrorResponse($e));
    }
}
