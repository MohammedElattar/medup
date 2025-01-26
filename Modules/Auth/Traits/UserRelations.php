<?php

namespace Modules\Auth\Traits;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Auth\Enums\AuthEnum;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Role\Models\Role;
use Modules\Vendor\Models\Vendor;
use Modules\Wallet\Entities\Wallet;

trait UserRelations
{
    public function avatar()
    {
        return MediaHelper::mediaRelationship($this, AuthEnum::AVATAR_COLLECTION_NAME);
    }

    public function inventoryOwner(): HasOne
    {
        return $this->hasOne(InventoryOwner::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissionsOnly(): BelongsToMany
    {
        return $this->roles();
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
