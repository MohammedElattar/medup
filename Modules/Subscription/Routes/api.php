<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Subscription\Http\Controllers\SubscriptionController;

Route::group(['prefix' => 'experts/me/subscription', 'middleware' => GeneralHelper::generalExpertMiddlewares()], function(){
    Route::get('', [SubscriptionController::class, 'show']);
    Route::post('renew', [SubscriptionController::class, 'renew']);
    Route::post('cancel', [SubscriptionController::class, 'cancel']);
});
