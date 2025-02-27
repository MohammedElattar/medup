<?php

namespace Modules\Collaborate\Services;

use Modules\Collaborate\Models\Builders\CollaborateBuilder;
use Modules\Collaborate\Models\Collaborate;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Speciality\Services\AdminSpecialityService;

class PublicCollaborateService
{
    use ExpertSetter;

    public function __construct(
        private readonly AdminSpecialityService $adminSpecialityService,
    )
    {
    }

    public function index(array $filters)
    {
        return Collaborate::query()
            ->when(true, fn(CollaborateBuilder $b) => $b->withFilters($filters)->withDetailsForPublic())
            ->searchable(['title'])
            ->where('status', true)
            ->latest()
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Collaborate::query()
            ->where('status', true)
            ->when(true, fn(CollaborateBuilder $b) => $b->withDetailsForPublic())
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        $this->adminSpecialityService->exists($data['speciality_id']);

        Collaborate::query()->create($data + [
            'expert_id' => $this->getExpert()->id,
        ]);
    }
}
