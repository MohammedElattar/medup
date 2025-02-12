<?php

namespace Modules\Expert\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Expert\Http\Requests\ExpertExperienceRequest;
use Modules\Expert\Services\ExpertExperienceService;
use Modules\Expert\Transformers\ExpertExperienceResource;

class ExpertExperienceController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly ExpertExperienceService $experienceService)
    {
    }

    public function index()
    {
        $experiences = $this->experienceService->index();

        return $this->resourceResponse(ExpertExperienceResource::collection($experiences));
    }

    public function show($id)
    {
        $item = $this->experienceService->show($id);

        return $this->resourceResponse(ExpertExperienceResource::make($item));
    }

    public function store(ExpertExperienceRequest $request)
    {
        $this->experienceService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('expert_experience', 'created_female'));
    }

    public function update(ExpertExperienceRequest $request, $id)
    {
        $this->experienceService->update($request->validated(), $id);

        return $this->okResponse(message: translate_success_message('expert_experience', 'updated_female'));
    }

    public function destroy($id)
    {
        $this->experienceService->destroy($id);

        return $this->okResponse(message: translate_success_message('expert_experience', 'deleted_female'));
    }
}
