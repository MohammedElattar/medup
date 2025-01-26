<?php

namespace Modules\Order\Http\Controllers;

use App\Traits\HttpResponse;
use Modules\Order\Http\Requests\OrderStatusPivotRequest;
use Modules\Order\Models\OrderStatusPivot;
use Modules\OrderStatus\Models\OrderStatus;

class AdminOrderStatusController
{
    use HttpResponse;

    public function index($orderId)
    {
        $items = OrderStatusPivot::query()->where('order_id', $orderId)->with('status:id,name')->get();

        return view('order::statuses.index', compact('items', 'orderId'));
    }

    public function create($orderId)
    {
        $orderStatuses = OrderStatus::query()->latest()->get(['id', 'name']);

        return view('order::statuses.create', compact('orderId', 'orderStatuses'));
    }

    public function store(OrderStatusPivotRequest $request, $orderId)
    {
        OrderStatusPivot::query()->create(array_merge($request->validated(), ['order_id' => $orderId]));

        return redirect()->route('orders.statuses.index', $orderId);
    }

    public function show($orderId, $id)
    {
        $item = OrderStatusPivot::query()->where('order_id', $orderId)->where('id', $id)->with('status:id,name')->firstOrFail();
        $orderStatuses = OrderStatus::query()->latest()->get(['id', 'name']);

        return view('order::statuses.show', compact('item', 'orderId', 'orderStatuses'));
    }

    public function update(OrderStatusPivotRequest $request, $orderId, $id)
    {
        $item = OrderStatusPivot::query()->where('order_id', $orderId)->where('id', $id)->firstOrFail();
        $item->update($request->validated());

        return redirect()->route('orders.statuses.index', $orderId);
    }

    public function destroy($orderId, $id)
    {
        OrderStatusPivot::query()->where('order_id', $orderId)->where('id', $id)->firstOrFail()->delete();

        return redirect()->route('orders.statuses.index', $orderId);
    }
}
