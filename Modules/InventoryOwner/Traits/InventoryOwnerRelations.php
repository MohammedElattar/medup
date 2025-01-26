<?php

namespace Modules\InventoryOwner\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InventoryOwnerRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
