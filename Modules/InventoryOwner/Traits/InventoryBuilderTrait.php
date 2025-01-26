<?php

namespace Modules\InventoryOwner\Traits;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait InventoryBuilderTrait
{
    public function withMinimalDetails(): self
    {
        return $this->with(['user' => fn (UserBuilder|BelongsTo $b) => $b->withMinimalDetails(false, additionalColumns: ['email', 'phone'])->withSum('wallet', 'balance')->withTrashed()]);
    }

    public function withDetails(): self
    {
        return $this->withMinimalDetails();
    }
}
