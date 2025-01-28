<?php

namespace Modules\Skill\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Skill\Models\Skill;
use Nette\Schema\ValidationException;

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

    /**
     * @throws ValidationErrorsException
     */
    public function exist(array $ids, string $errorKey = 'skills.*')
    {
        $items = Skill::query()->whereIntegerInRaw('id', $ids)->get();
        $existingIds = $items->pluck('id')->toArray();
        $counter = 0;

        foreach($ids as $id) {
            if(! in_array($id, $existingIds)) {
                throw new ValidationErrorsException([
                    Str::replace('*', $counter, $errorKey) => translate_error_message('skill', 'not_exists'),
                ]);
            }

            $counter++;
        }

        return $items;
    }
}
