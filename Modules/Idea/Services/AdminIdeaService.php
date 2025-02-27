<?php

namespace Modules\Idea\Services;

use Modules\Collaborate\Models\Builders\CollaborateBuilder;
use Modules\Idea\Models\Idea;

class AdminIdeaService
{
    public function index()
    {
        return Idea::query()
            ->latest()
            ->when(true, fn(CollaborateBuilder $b) => $b->withDetailsForPublic())
            ->searchable(['title'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Idea::query()->findOrFail($id);
    }
}
