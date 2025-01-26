<?php

namespace Modules\InventoryOwner\Helpers;

use Modules\InventoryOwner\Exceptions\InventoryOwnerException;
use Modules\InventoryOwner\Models\InventoryOwner;

class InventoryOwnerHelper
{
    /**
     * @throws InventoryOwnerException
     */
    public static function getUserInventoryOwner($user = null)
    {
        $user = $user ?: auth()->user();
        $owner = $user->inventoryOwner;

        if (! $owner) {
            InventoryOwnerException::notExists();
        }

        return $owner;
    }

    /**
     * @throws InventoryOwnerException
     */
    public static function getById($id = null)
    {
        if (is_null($id)) {
            return self::getUserInventoryOwner();
        }

        $owner = InventoryOwner::find($id);

        if (! $owner) {
            InventoryOwnerException::notExists();
        }

        return $owner;
    }
}
