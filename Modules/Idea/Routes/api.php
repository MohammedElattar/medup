<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Idea\Http\Controllers\PublicIdeaController;

Route::group(['prefix' => 'public/ideas'], function(){
    Route::get('', [PublicIdeaController::class, 'index']);
    Route::get('{id}', [PublicIdeaController::class, 'show']);
    Route::post('', [PublicIdeaController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});
