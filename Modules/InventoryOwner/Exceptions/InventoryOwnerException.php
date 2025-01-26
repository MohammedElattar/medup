<?php

namespace Modules\InventoryOwner\Exceptions;

use App\Exceptions\BaseExceptionClass;
use Symfony\Component\HttpFoundation\Response;

class InventoryOwnerException extends BaseExceptionClass
{
    public static function notExists()
    {
        throw new self(translate_error_message('inventory_owner', 'not_exists'), Response::HTTP_NOT_FOUND);
    }
}
