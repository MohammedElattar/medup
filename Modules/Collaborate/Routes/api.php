<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Collaborate\Http\Controllers\PublicCollaborateController;

Route::group(['prefix' => 'public/collaborates'], function(){
    Route::get('', [PublicCollaborateController::class, 'index']);
    Route::get('{id}', [PublicCollaborateController::class, 'show']);
    Route::post('', [PublicCollaborateController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});
