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

    public function topExperts()
    {
        return cache()->remember('top_experts', now()->addHours(2), function(){
          return $this->index(['only_top' => true]);
        });
    }
}
