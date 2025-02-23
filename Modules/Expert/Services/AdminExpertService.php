<?php

namespace Modules\Expert\Services;

use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Expert\Models\Expert;

class AdminExpertService
{
    public function index()
    {
        return Expert::query()
            ->when(true, fn(ExpertBuilder $b) => $b->withDetailsForAdmin())
            ->searchByRelation('user', ['name', 'email'])
            ->paginatedCollection();
    }
}
