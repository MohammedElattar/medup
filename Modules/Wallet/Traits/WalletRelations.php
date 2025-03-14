<?php

namespace Modules\Wallet\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Entities\Wallet;

trait WalletRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(
            Transaction::class,
            Wallet::class,
            'user_id',
            'user_id',
            'id',
            'user_id',
        );
    }

    public function incomingTransactions(): HasManyThrough
    {
        return $this->transactions()->where('transactions.incoming', true);
    }

    public function outgoingTransactions(): HasManyThrough
    {
        return $this->transactions()->where('transactions.incoming', false);
    }
}
