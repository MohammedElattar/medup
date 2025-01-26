<?php

namespace Modules\Product\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\CategoryResource;
use Modules\InventoryOwner\Transformers\InventoryOwnerResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->whenHas('name'),
            'price' => $this->whenHas('price'),
            'quantity' => $this->whenHas('quantity'),
            'image' => $this->whenNotNull(ResourceHelper::getFirstMediaOriginalUrl($this, 'image')),
            'description' => $this->whenHas('description'),
            'category' => $this->whenLoaded('category', function () {
                return CategoryResource::make($this->category);
            }),
            'inventory_owner' => $this->whenLoaded('inventoryOwner', function () {
                return InventoryOwnerResource::make($this->inventoryOwner);
            }),
        ];
    }
}
