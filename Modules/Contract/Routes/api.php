<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Contract\Http\Controllers\ContractController;

Route::group(['prefix' => 'public/contracts', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
    Route::get('', [ContractController::class, 'index']);
    Route::get('{id}', [ContractController::class, 'show']);
    Route::post('', [ContractController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});
