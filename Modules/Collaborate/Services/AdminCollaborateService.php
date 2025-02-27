<?php

namespace Modules\Collaborate\Services;

use Modules\Collaborate\Models\Builders\CollaborateBuilder;
use Modules\Collaborate\Models\Collaborate;

class AdminCollaborateService
{
    public function index()
    {
        return Collaborate::query()
            ->latest()
            ->when(true, fn(CollaborateBuilder $b) => $b->withDetailsForPublic())
            ->searchable(['title'])
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Collaborate::query()->findOrFail($id);
    }
}
