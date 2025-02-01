<?php

namespace Modules\Expert\Services;

use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Expert\Models\Expert;

class PublicExpertService
{
    public function index(array $filters)
    {
        return Expert::query()
            ->when(true, fn(ExpertBuilder $b) => $b->withMinimalPublicDetails()->handleFilters($filters))
            ->paginatedCollection();
    }
}
