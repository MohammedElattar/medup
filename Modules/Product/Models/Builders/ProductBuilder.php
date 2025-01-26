<?php

namespace Modules\Product\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Pipeline;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\InventoryOwner\Models\Builders\InventoryOwnerBuilder;
use Modules\Product\Models\Filters\ProductForeignKeyFilter;

class ProductBuilder extends Builder
{
    public function withMinimalAdminDetails(): ProductBuilder
    {
        return $this->select([
            'id',
            'name',
            'description',
            'quantity',
            'price',
            'category_id',
            'inventory_owner_id',
        ])
            ->withCategoryDetails()
            ->withImage()
            ->withInventoryOwnerDetails();
    }

    public function withMinimalDetailsForVendor()
    {
        return $this->withMinimalAdminDetails();
    }

    public function withDetailsForVendor()
    {
        return $this->withImage()->withCategoryDetails()->withInventoryOwnerDetails();
    }

    public function withAdminDetails()
    {
        return $this->withImage();
    }

    public function withCategoryDetails(): ProductBuilder
    {
        return $this->with('category:id,name');
    }

    public function withInventoryOwnerDetails(): ProductBuilder
    {
        return $this->with(['inventoryOwner.user' => fn (InventoryOwnerBuilder|BelongsTo $b) => $b->withMinimalDetails()->withTrashed()]);
    }

    public function handleFilters(array $filters = []): ProductBuilder
    {
        $this
            ->searchable(['name'], ['name']);

        return Pipeline::send($this)->through([
            fn ($query, $next) => ProductForeignKeyFilter::handle($query, $next, $filters),
        ])->thenReturn();
    }

    public function whereMine($id = null)
    {
        $user = auth()->user();

        if (UserTypeEnum::getUserType($user) == UserTypeEnum::INVENTORY_OWNER) {
            return $this->where('inventory_owner_id', $user->inventoryOwner->id);
        }

        return $this->when(! is_null($id), fn ($q) => $q->where('inventory_owner_id', $id));
    }

    public function withImage()
    {
        return $this->with('image');
    }

    public function whereParentsNotDeleted(): ProductBuilder
    {
        return $this->whereHas('inventoryOwner', fn (InventoryOwnerBuilder|BelongsTo $q) => $q->withTrashed());
    }
}
