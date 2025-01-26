<?php

namespace Modules\Order\Services;

use Modules\Order\Models\Builders\OrderBuilder;
use Modules\Order\Models\Order;

class AdminOrderService
{
    public function index()
    {
        return Order::query()
            ->when(true, fn (OrderBuilder $b) => $b->withProductDetails()->whereAccessible())
            ->latest()
            ->paginatedCollection();
    }
}
