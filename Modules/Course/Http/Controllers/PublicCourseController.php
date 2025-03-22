<?php

namespace Modules\Course\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\RequestHelper;
use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Course\Http\Requests\CourseFilterRequest;
use Modules\Course\Http\Requests\CourseRequest;
use Modules\Course\Services\PublicCourseService;
use Modules\Course\Transformers\CourseResource;

class PublicCourseController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicCourseService $publicCourseService)
    {
        RequestHelper::loginIfHasToken($this, GeneralHelper::getDefaultLoggedUserMiddlewares());
    }

    public function index(CourseFilterRequest $request)
    {
        $courses = $this->publicCourseService->index($request->validated());

        return $this->paginatedResponse($courses, CourseResource::class);
    }

    public function show($id): JsonResponse
    {
        $course = $this->publicCourseService->show($id);

        return $this->resourceResponse(CourseResource::make($course));
    }

    public function store(CourseRequest $request)
    {
        $this->publicCourseService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('course', 'created'));
    }
}
