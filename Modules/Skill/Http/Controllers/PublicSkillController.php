<?php

namespace Modules\Skill\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Skill\Services\PublicSkillService;
use Modules\Skill\Transformers\SkillResource;

class PublicSkillController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicSkillService $publicSkillService)
    {
    }

    public function index()
    {
        $skills = $this->publicSkillService->index();

        return $this->paginatedResponse($skills, SkillResource::class);
    }
}
