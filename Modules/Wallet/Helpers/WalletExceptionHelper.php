<?php

namespace Modules\Wallet\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\Wallet\Exceptions\WalletException;

class WalletExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn (WalletException $e) => self::generalErrorResponse($e));
    }
}
