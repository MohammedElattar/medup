<?php

namespace Modules\College\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\College\Services\PublicCollegeService;
use Modules\College\Transformers\CollegeResource;

class PublicCollegeController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicCollegeService $publicCollegeService)
    {
    }

    public function index()
    {
        return $this->resourceResponse(CollegeResource::collection($this->publicCollegeService->collegesWithBestExpert()));
    }
}
