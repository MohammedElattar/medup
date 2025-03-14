<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Order\Http\Controllers\OrderController;

Route::group(['prefix' => 'public/orders', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares([
    GeneralHelper::userTypeIn(array_filter(UserTypeEnum::availableTypes(), fn($type) => $type !== UserTypeEnum::ADMIN))
])], function(){
    Route::get('', [OrderController::class, 'index']);
    Route::post('', [OrderController::class, 'store']);
});
