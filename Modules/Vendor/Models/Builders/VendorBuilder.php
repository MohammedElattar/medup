<?php

namespace Modules\Vendor\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\InventoryOwner\Contracts\InventoryOwnerContract;
use Modules\InventoryOwner\Traits\InventoryBuilderTrait;

class VendorBuilder extends Builder implements InventoryOwnerContract
{
    use InventoryBuilderTrait;
}
