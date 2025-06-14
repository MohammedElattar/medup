<?php

namespace Modules\Payment\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Modules\Payment\Contracts\BankAccountContract;

class BankAccountBuilder extends Builder
{
    public function whereMine(?BankAccountContract $user = null)
    {
        $user = $user ?: auth()->user();

        return $this->where('bankable_id', $user->getKey())->where('bankable_type', get_class($user));
    }
}
