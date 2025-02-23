<?php

namespace Modules\Idea\Services;

use Modules\Idea\Models\Builders\IdeaBuilder;
use Modules\Idea\Models\Idea;

class AdminIdeaService
{
    public function index()
    {
        return Idea::query()
            ->latest()
            ->when(true, fn(IdeaBuilder $b) => $b->withDetailsForPublic())
            ->searchable(['title'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Idea::query()->findOrFail($id);
    }


}
