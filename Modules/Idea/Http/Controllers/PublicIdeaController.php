<?php

namespace Modules\Idea\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Idea\Http\Requests\IdeaFilterRequest;
use Modules\Idea\Http\Requests\IdeaRequest;
use Modules\Idea\Services\PublicIdeaService;
use Modules\Idea\Transformers\IdeaResource;

class PublicIdeaController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicIdeaService $publicIdeaService)
    {
    }

    public function index(IdeaFilterRequest $request)
    {
        $ideas = $this->publicIdeaService->index($request->validated());

        return $this->paginatedResponse($ideas, IdeaResource::class);
    }

    public function show($id)
    {
        $idea = $this->publicIdeaService->show($id);

        return $this->resourceResponse(IdeaResource::make($idea));
    }

    public function store(IdeaRequest $request)
    {
        $this->publicIdeaService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('idea', 'created'));
    }
}
