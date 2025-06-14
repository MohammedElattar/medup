<?php

namespace Modules\Skill\Services;

use Modules\Skill\Models\Skill;

class PublicSkillService
{
    public function index()
    {
        return Skill::query()
            ->latest()
            ->with('icon')
            ->withCount('experts')
            ->searchable()
            ->paginatedCollection();
    }
}
