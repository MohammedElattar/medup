<?php

namespace Modules\Wallet\Entities\Builders;

use App\Models\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Order\Models\Builders\OrderBuilder;
use Modules\Wallet\Traits\WalletTrait;

class TransactionQueryBuilder extends Builder
{
    use WalletTrait;

    public function withOrderDetails(): TransactionQueryBuilder
    {
        return $this->with([
            'order' => fn(OrderBuilder|BelongsTo $b) => $b->withProductDetails(),
            'user' => fn(UserBuilder|BelongsTo $b) => $b->select(['id', 'name', 'type'])->withTrashed()
        ]);
    }
}
