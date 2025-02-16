<?php

namespace Modules\Expert\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CertificationBuilder extends Builder
{
    public function withDetails()
    {
        return $this->with('file');
    }
}
