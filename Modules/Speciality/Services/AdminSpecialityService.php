<?php

namespace Modules\Speciality\Services;

use App\Exceptions\ValidationErrorsException;
use Modules\College\Services\AdminCollegeService;
use Modules\Speciality\Models\Speciality;

readonly class AdminSpecialityService
{
    public function __construct(private AdminCollegeService $collegeService) {}

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

        Speciality::query()->create($data + ['college_id' => $collegeId]);
    }

    public function update(array $data, $collegeId, $id)
    {
        $this->collegeService->exists($collegeId);

        Speciality::query()->where('college_id', $collegeId)->findOrFail($id)->update($data);
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
