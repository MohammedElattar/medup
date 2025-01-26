<?php

namespace Modules\InventoryOwner\Helpers;

use App\Helpers\BaseExceptionHelper;
use Illuminate\Foundation\Configuration\Exceptions;
use Modules\InventoryOwner\Exceptions\InventoryOwnerException;

class InventoryOwnerExceptionHelper extends BaseExceptionHelper
{
    public static function handle(Exceptions $exceptions)
    {
        $exceptions->renderable(fn (InventoryOwnerException $e) => self::generalErrorResponse($e));
    }
}
