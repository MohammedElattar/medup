<?php

namespace Modules\Product\Traits;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Category\Models\Category;
use Modules\InventoryOwner\Models\InventoryOwner;

trait ProductRelations
{
    public function image()
    {
        return MediaHelper::mediaRelationship($this, 'products');
    }

    public function inventoryOwner(): BelongsTo
    {
        return $this->belongsTo(InventoryOwner::class)->withTrashed();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
}
