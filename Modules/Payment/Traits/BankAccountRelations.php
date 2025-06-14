<?php

namespace Modules\Payment\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait BankAccountRelations
{
    public function bankable(): MorphTo
    {
        return $this->morphTo();
    }
}
