<?php

namespace Modules\InventoryOwner\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\InventoryOwner\Services\PublicInventoryOwnerService;
use Modules\InventoryOwner\Transformers\InventoryOwnerResource;

class PublicInventoryOwnerController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicInventoryOwnerService $publicInventoryOwnerService) {}

    public function index()
    {
        $owners = $this->publicInventoryOwnerService->index();

        return $this->resourceResponse(InventoryOwnerResource::collection($owners));
    }
}
