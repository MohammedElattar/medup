<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\AdminOrderController;
use Modules\Order\Http\Controllers\AdminOrderStatusController;

Route::group(['prefix' => 'admin/orders', 'middleware' => GeneralHelper::dashboardUserMiddlewares()], function () {
    Route::get('', [AdminOrderController::class, 'index'])->name('orders.index');
});
