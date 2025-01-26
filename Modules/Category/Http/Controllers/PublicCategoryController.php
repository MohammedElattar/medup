<?php

namespace Modules\Category\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Category\Services\PublicCategoryService;
use Modules\Category\Transformers\CategoryResource;

class PublicCategoryController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicCategoryService $publicCategoryService) {}

    public function index()
    {
        $categories = $this->publicCategoryService->index();

        return $this->resourceResponse(CategoryResource::collection($categories));
    }
}
