<?php

namespace Modules\Skill\Services;

use Modules\Skill\Models\Skill;

class PublicSkillService
{
    public function index()
    {
        $specialities = array_filter(explode(',', request()->input('specialities', '')) ?: []);

        return Skill::query()
            ->latest()
            ->with('icon')
            ->withCount('experts')
            ->when(!empty($specialities), fn($q) => $q->whereHas('specialities', fn($q) => $q->whereIn('specialities.id', $specialities)))
            ->searchable()
            ->paginatedCollection();
    }
}
