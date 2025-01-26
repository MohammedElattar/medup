<?php

namespace Modules\Product\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Category\Services\AdminCategoryService;
use Modules\InventoryOwner\Services\AdminInventoryOwnerService;
use Modules\Product\Models\Builders\ProductBuilder;
use Modules\Product\Models\Product;

class AdminProductService
{
    public function __construct(
        private readonly AdminCategoryService $adminCategoryService,
        private readonly AdminInventoryOwnerService $inventoryOwnerService,
    ) {}

    public function index()
    {
        return Product::query()
            ->latest()
            ->when(true,
                fn (ProductBuilder $b) => $b
                    ->withMinimalAdminDetails()
                    ->handleFilters()
                    ->whereMine()
            )
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Product::query()
            ->when(true,
                fn (ProductBuilder $b) => $b
                    ->withAdminDetails()
                    ->whereMine()
            )
            ->findOrFail($id);
    }

    /**
     * @throws ValidationErrorsException
     */
    public function store(array $data)
    {
        $this->adminCategoryService->exists($data['category_id']);

        if (isset($data['inventory_owner_id'])) {
            $this->inventoryOwnerService->exists($data['inventory_owner_id']);
        }

        DB::transaction(function () use ($data) {
            $inventoryOwner = $data['inventory_owner_id'] ?? auth()->user()->inventoryOwner->id;

            $product = Product::query()->create($data + ['inventory_owner_id' => $inventoryOwner]);
            (new ImageService($product, $data))->storeOneMediaFromRequest('products', 'image');
        });
    }

  /**
   * @throws ValidationErrorsException
   */
  public function update(array $data, $id)
    {
        $this->adminCategoryService->exists($data['category_id']);

        if (isset($data['inventory_owner_id'])) {
            $this->inventoryOwnerService->exists($data['inventory_owner_id']);
        }

        DB::transaction(function () use ($data, $id) {
            $product = Product::query()->when(true, fn (ProductBuilder $b) => $b->whereMine())->findOrFail($id);

            $product->update($data);
            (new ImageService($product, $data))->updateOneMedia('products', 'image');
        });
    }

    public function destroy($id)
    {
        $product = Product::query()->when(true, fn (ProductBuilder $b) => $b->whereMine())->findOrFail($id);
        $product->delete();
    }
}
