<?php

namespace Modules\Speciality\Services;

use App\Exceptions\ValidationErrorsException;
use Illuminate\Support\Facades\DB;
use Modules\College\Services\AdminCollegeService;
use Modules\Skill\Services\AdminSkillService;
use Modules\Speciality\Models\Speciality;

readonly class AdminSpecialityService
{
    public function __construct(private AdminCollegeService $collegeService, private AdminSkillService $adminSkillService) {}

    public function index($collegeId)
    {
        return Speciality::query()
            ->where('college_id', $collegeId)
            ->latest()
            ->paginatedCollection();
    }

    public function show($collegeId, $id)
    {
        return Speciality::query()
            ->where('college_id', $collegeId)
            ->findOrFail($id);
    }

    public function store(array $data, $collegeId)
    {
        $this->collegeService->exists($collegeId);
        $this->adminSkillService->exist($data['skills']);

        DB::transaction(function() use ($data, $collegeId){
            $item = Speciality::query()->create($data + ['college_id' => $collegeId]);
            $item->skills()->attach($data['skills']);
        });
    }

    public function update(array $data, $collegeId, $id)
    {
        $this->collegeService->exists($collegeId);
        $this->adminSkillService->exist($data['skills']);

        DB::transaction(function() use ($data, $collegeId, $id){
            $item = Speciality::query()->where('college_id', $collegeId)->findOrFail($id);

            $item->update($data);

            $item->skills()->sync($data['skills']);
        });
    }

    public function destroy($collegeId, $id)
    {
        Speciality::query()->where('college_id', $collegeId)->findOrFail($id)->delete();
    }

    /**
     * @throws ValidationErrorsException
     */
    public function exists(int $id, string $errorKey = 'speciality_id')
    {
        $speciality = Speciality::query()->find($id);

        if(! $speciality) {
            throw new ValidationErrorsException([
                $errorKey => translate_error_message('speciality', 'not_exists'),
            ]);
        }

        return $speciality;
    }
}
