<?php

namespace Modules\Expert\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\RequestHelper;
use App\Traits\HttpResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Routing\Controller;
use Modules\Expert\Http\Requests\ExpertFilterRequest;
use Modules\Expert\Services\PublicExpertService;
use Modules\Expert\Transformers\ExpertResource;
use Modules\Review\Http\Requests\ReviewRequest;

class PublicExpertController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicExpertService $publicExpertService)
    {
        RequestHelper::loginIfHasToken($this, GeneralHelper::getDefaultLoggedUserMiddlewares());
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

    /**
     * @throws AuthenticationException
     */
    public function review(ReviewRequest $request, $id)
    {
        if(! auth()->check()) {
            $this->throwNotAuthenticated();
        }

        $this->publicExpertService->review($request->validated(), $id);

        return $this->createdResponse(message: translate_success_message('expert', 'reviewed'));
    }
}
