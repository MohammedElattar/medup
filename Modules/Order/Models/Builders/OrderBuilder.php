<?php

namespace Modules\Order\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\InventoryOwner\Helpers\InventoryOwnerHelper;
use Modules\Product\Models\Builders\ProductBuilder;

class OrderBuilder extends Builder
{
    public function withProductDetails(): OrderBuilder
    {
        return $this->with([
            'product' => fn(ProductBuilder|BelongsTo $b) => $b
                ->select(['id', 'name', 'inventory_owner_id'])
                ->withInventoryOwnerDetails()
                ->withTrashed(),
        ]);
    }

    public function whereAccessible()
    {
        if(UserTypeEnum::getUserType() == UserTypeEnum::INVENTORY_OWNER) {
            return $this->whereHas(
                'product',
                fn(ProductBuilder $b) => $b->where(
                    'inventory_owner_id',
                    InventoryOwnerHelper::getUserInventoryOwner()->id
                )->withTrashed()
            );
        }
    }
}
