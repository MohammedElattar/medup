<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Course\Http\Controllers\PublicCourseController;

Route::group(['prefix' => 'public/courses'], function(){
    Route::get('', [PublicCourseController::class, 'index']);
    Route::get('{id}', [PublicCourseController::class, 'show']);
    Route::post('', [PublicCourseController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});
