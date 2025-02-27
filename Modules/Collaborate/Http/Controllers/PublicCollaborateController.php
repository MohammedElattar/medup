<?php

namespace Modules\Collaborate\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Collaborate\Http\Requests\CollaborateFilterRequest;
use Modules\Collaborate\Http\Requests\CollaborateRequest;
use Modules\Collaborate\Services\PublicCollaborateService;
use Modules\Collaborate\Transformers\CollaborateResource;

class PublicCollaborateController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicCollaborateService $publicIdeaService)
    {
    }

    public function index(CollaborateFilterRequest $request)
    {
        $ideas = $this->publicIdeaService->index($request->validated());

        return $this->paginatedResponse($ideas, CollaborateResource::class);
    }

    public function show($id)
    {
        $idea = $this->publicIdeaService->show($id);

        return $this->resourceResponse(CollaborateResource::make($idea));
    }

    public function store(CollaborateRequest $request)
    {
        $this->publicIdeaService->store($request->validated());

        return $this->createdResponse(message: translate_success_message('collaborate', 'created'));
    }
}
