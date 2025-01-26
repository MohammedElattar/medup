<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\PublicProductController;

Route::group(['prefix' => 'public/products', 'middleware' => GeneralHelper::vendorMiddlewares()], function () {
    Route::get('', [PublicProductController::class, 'index']);
    Route::get('{id}', [PublicProductController::class, 'show']);
    Route::post('{id}', [PublicProductController::class, 'order']);
});
