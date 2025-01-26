<?php

namespace Modules\Wallet\Entities\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Wallet\Traits\WalletTrait;

class WalletQueryBuilder extends Builder
{
    use WalletTrait;
}
