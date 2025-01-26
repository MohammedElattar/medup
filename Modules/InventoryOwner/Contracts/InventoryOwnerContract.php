<?php

namespace Modules\InventoryOwner\Contracts;

interface InventoryOwnerContract
{
    public function withMinimalDetails();

    public function withDetails();
}
