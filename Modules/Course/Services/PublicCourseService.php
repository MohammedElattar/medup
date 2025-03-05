<?php

namespace Modules\Course\Services;

use App\Exceptions\ValidationErrorsException;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Modules\Course\Models\Builders\CourseBuilder;
use Modules\Course\Models\Course;
use Modules\Expert\Traits\ExpertSetter;
use Modules\Speciality\Services\AdminSpecialityService;

class PublicCourseService
{
    use ExpertSetter;

    public function __construct(private readonly AdminSpecialityService $adminSpecialityService)
    {
    }

    public function index(array $filters)
    {
        return Course::query()
            ->when(true, fn(CourseBuilder $b) => $b->handleFilters($filters)->withMinimalDetailsForPublic())
            ->searchable()
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Course::query()
            ->when(true, fn(CourseBuilder $b) => $b->withDetailsForPublic())
            ->findOrFail($id);
    }

    /**
     * @throws ValidationErrorsException
     */
    public function store(array $data)
    {
        $this->adminSpecialityService->exists($data['speciality_id']);
        $this->assertUnique($data['name']);

        DB::transaction(function() use ($data){
            $course = Course::query()->create($data + ['expert_id' => $this->getExpert()->id]);

            $imageService = new ImageService($course, $data);
            $imageService->storeOneMediaFromRequest('course_cover', 'cover');
        });
    }

    /**
     * @throws ValidationErrorsException
     */
    private function assertUnique(string $name)
    {
        $exists = Course::query()
            ->where('name', $name)
            ->where('expert_id', $this->getExpert()->id)
            ->exists();

        if($exists) {
            throw new ValidationErrorsException([
                'name' => translate_error_message('name', 'exists'),
            ]);
        }
    }
}
