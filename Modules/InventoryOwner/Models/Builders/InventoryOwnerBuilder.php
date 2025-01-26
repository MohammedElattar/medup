<?php

namespace Modules\InventoryOwner\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\InventoryOwner\Contracts\InventoryOwnerContract;
use Modules\InventoryOwner\Traits\InventoryBuilderTrait;

class InventoryOwnerBuilder extends Builder implements InventoryOwnerContract
{
    use InventoryBuilderTrait;
}
