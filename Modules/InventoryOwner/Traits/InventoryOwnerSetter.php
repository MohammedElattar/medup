<?php

namespace Modules\InventoryOwner\Traits;

use Modules\InventoryOwner\Helpers\InventoryOwnerHelper;
use Modules\InventoryOwner\Models\InventoryOwner;

trait InventoryOwnerSetter
{
    public ?InventoryOwner $inventoryOwner;

    public function setInventoryOwner($inventoryOwner): void
    {
        $this->inventoryOwner = $inventoryOwner;
    }

    public function getInventoryOwner()
    {
        return $this->inventoryOwner ?: InventoryOwnerHelper::getById();
    }
}
