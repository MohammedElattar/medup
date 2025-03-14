<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Modules\Order\Http\Requests\OrderRequest;
use Modules\Order\Services\OrderService;
use Modules\Order\Transformers\OrderResource;

class OrderController extends Controller
{
    use HttpResponse;

    public function __construct(private OrderService $orderService)
    {
    }

    public function index()
    {
        $orders = $this->orderService->index();

        return $this->paginatedResponse($orders, OrderResource::class);
    }

    public function store(OrderRequest $request)
    {
        $order = $this->orderService->store($request->validated());

        return $this->createdResponse(OrderResource::make($order), translate_word('item_purchased'));
    }
}
