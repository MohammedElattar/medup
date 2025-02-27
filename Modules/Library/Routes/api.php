<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\PublicLibraryController;

Route::group(['prefix' => 'public/library'], function(){
    Route::get('', [PublicLibraryController::class, 'index']);
    Route::get('{id}', [PublicLibraryController::class, 'show']);

    Route::post('', [PublicLibraryController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});
