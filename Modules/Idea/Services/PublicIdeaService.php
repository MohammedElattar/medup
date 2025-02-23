<?php

namespace Modules\Idea\Services;

use Modules\Expert\Services\ExpertService;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Idea\Models\Builders\IdeaBuilder;
use Modules\Idea\Models\Idea;
use Modules\Speciality\Services\AdminSpecialityService;

class PublicIdeaService
{
    use ExpertSetter;

    public function __construct(
        private readonly AdminSpecialityService $adminSpecialityService,
    )
    {
    }

    public function index(array $filters)
    {
        return Idea::query()
            ->when(true, fn(IdeaBuilder $b) => $b->withFilters($filters)->withDetailsForPublic())
            ->searchable(['title'])
            ->where('status', true)
            ->latest()
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Idea::query()
            ->where('status', true)
            ->when(true, fn(IdeaBuilder $b) => $b->withDetailsForPublic())
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $this->adminSpecialityService->exists($data['speciality_id']);

        Idea::query()->create($data + [
            'expert_id' => $this->getExpert()->id,
        ]);
    }
}
