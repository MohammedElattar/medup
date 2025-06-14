<?php

namespace Modules\Payment\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Payment\Models\BankAccount;

trait HasBankAccount
{
    public function bankAccounts(): MorphMany
    {
        return $this->morphMany(BankAccount::class, 'bankable');
    }

    public function bankAccount(): MorphOne
    {
        return $this->morphOne(BankAccount::class, 'bankable');
    }

    public function activeBankAccount(): MorphOne
    {
        return $this->morphOne(BankAccount::class, 'bankable')->where('is_active', true);
    }
}
