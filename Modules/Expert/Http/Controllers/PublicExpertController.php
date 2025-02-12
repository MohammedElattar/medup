<?php

namespace Modules\Expert\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Expert\Http\Requests\ExpertFilterRequest;
use Modules\Expert\Services\PublicExpertService;
use Modules\Expert\Transformers\ExpertResource;

class PublicExpertController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicExpertService $publicExpertService)
    {
    }

    public function index(ExpertFilterRequest $request)
    {
        $experts = $request->has('only_top') ? $this->publicExpertService->topExperts() : $this->publicExpertService->index($request->validated());

        return $this->paginatedResponse($experts, ExpertResource::class);
    }

    public function show($id)
    {
        $expert = $this->publicExpertService->show($id);

        return $this->resourceResponse(ExpertResource::make($expert));
    }
}
