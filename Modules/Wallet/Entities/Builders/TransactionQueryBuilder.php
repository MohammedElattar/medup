<?php

namespace Modules\Wallet\Entities\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Wallet\Traits\WalletTrait;

class TransactionQueryBuilder extends Builder
{
    use WalletTrait;
}
