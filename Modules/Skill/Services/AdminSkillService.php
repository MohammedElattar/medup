<?php

namespace Modules\Skill\Services;

use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Skill\Models\Skill;

class AdminSkillService
{
    public function index()
    {
        return Skill::query()->latest()->with('icon')->paginatedCollection();
    }

    public function show($id)
    {
        return Skill::query()->with('icon')->findOrFail($id);
    }

    public function store(array $data)
    {
        DB::transaction(function () use ($data) {
            $skill = Skill::query()->create($data);
            $imageService = new ImageService($skill, $data);
            $imageService->storeOneMediaFromRequest('skill_icon', 'icon');
        });
    }

    public function update(array $data, $id)
    {
        DB::transaction(function () use ($id, $data) {
            $skill = Skill::query()->findOrFail($id);
            $skill->update($data);
            $imageService = new ImageService($skill, $data);
            $imageService->updateOneMedia('skill_icon', 'icon');
        });
    }

    public function destroy($id)
    {
        Skill::query()->findOrFail($id)->delete();
    }
}
