<?php

namespace Modules\Ad\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Ad\Models\Ad;
use Modules\Ad\Transformers\AdResource;

class PublicAdController extends Controller
{
    use HttpResponse;

    public function index()
    {
        $ads = Ad::query()
            ->inRandomOrder()
            ->with('image')
            ->get();

        return $this->resourceResponse(AdResource::collection($ads));
    }
}
