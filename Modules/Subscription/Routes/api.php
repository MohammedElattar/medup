<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Helpers\UserTypeHelper;
use Modules\Subscription\Http\Controllers\SubscriptionController;

Route::group(['prefix' => 'subscription', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares([
    GeneralHelper::userTypeIn(UserTypeHelper::mobileTypes())
])], function(){
    Route::get('', [SubscriptionController::class, 'show']);
    Route::post('upgrade', [SubscriptionController::class, 'upgrade']);
    Route::post('renew', [SubscriptionController::class, 'renew']);
});
