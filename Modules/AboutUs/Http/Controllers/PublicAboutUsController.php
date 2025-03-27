<?php

namespace Modules\AboutUs\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\AboutUs\Services\AboutUsService;
use Modules\AboutUs\Transformers\AboutUsResource;

class PublicAboutUsController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly AboutUsService $aboutUsService) {}

    public function index()
    {
        $items = $this->aboutUsService->index(true);

        return $this->resourceResponse(AboutUsResource::collection($items));
    }

    public function show($id)
    {
        $item = $this->aboutUsService->show($id, true);

        return $this->resourceResponse(AboutUsResource::make($item));
    }
}
