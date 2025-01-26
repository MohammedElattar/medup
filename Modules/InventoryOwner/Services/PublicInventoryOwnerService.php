<?php

namespace Modules\InventoryOwner\Services;

use Modules\InventoryOwner\Models\Builders\InventoryOwnerBuilder;
use Modules\InventoryOwner\Models\InventoryOwner;

class PublicInventoryOwnerService
{
    public function index()
    {
        return InventoryOwner::query()
            ->when(true, fn (InventoryOwnerBuilder $b) => $b->withMinimalDetails())
            ->latest()
            ->searchByRelation('user', ['name'])
            ->get();
    }
}
