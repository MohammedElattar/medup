<?php

namespace Modules\Product\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\ProductFilterRequest;
use Modules\Product\Http\Requests\ProductOrderRequest;
use Modules\Product\Services\PublicProductService;
use Modules\Product\Transformers\ProductResource;

class PublicProductController extends Controller
{
    use HttpResponse;

    public function __construct(private readonly PublicProductService $publicProductService) {}

    public function index(ProductFilterRequest $request)
    {
        $products = $this->publicProductService->index($request->validated());

        return $this->paginatedResponse($products, ProductResource::class);
    }

    public function show($id)
    {
        $product = $this->publicProductService->show($id);

        return $this->resourceResponse(ProductResource::make($product));
    }

    public function order(ProductOrderRequest $request, $id)
    {
        $this->publicProductService->order($request->validated(), $id);

        return $this->createdResponse(message: translate_success_message('order', 'created'));
    }
}
