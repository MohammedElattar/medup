<?php

namespace Modules\Expert\Services;

use Illuminate\Support\Facades\DB;
use Modules\Expert\Models\Builders\ExpertBuilder;
use Modules\Expert\Models\Expert;

class PublicExpertService
{
    public function index(array $filters)
    {
        return Expert::query()
            ->when(
                true,
                fn(ExpertBuilder $b) => $b
                    ->withMinimalPublicDetails()
                    ->handleFilters($filters)
            )
            ->paginatedCollection();
    }

    public function topExperts()
    {
//        return cache()->remember('top_experts', now()->addHour(), function(){
          return $this->index(['only_top' => true]);
//        });
    }

    public function show($id)
    {
        return Expert::query()->when(true, fn(ExpertBuilder $b) => $b->withDetailsForPublic())->findOrFail($id);
    }

    public function review(array $data, $id)
    {
        $expert = Expert::query()
            ->whereDoesntHave('reviews', fn($q) => $q->where('user_id', auth()->id()))
            ->findOrFail($id);

        DB::transaction(fn() => $expert->review($data));
    }
}
