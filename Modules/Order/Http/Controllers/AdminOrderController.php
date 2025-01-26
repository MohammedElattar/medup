<?php

namespace Modules\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Order\Services\AdminOrderService;

class AdminOrderController extends Controller
{
    public function __construct(private readonly AdminOrderService $adminOrderService) {}

    public function index()
    {
        $orders = $this->adminOrderService->index();

        return view('order::index', compact('orders'));
    }
}
