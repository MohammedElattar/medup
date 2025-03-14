<?php

namespace Modules\Wallet\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait TransactionRelations
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
