<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Expert\Http\Controllers\ExpertCertificationController;
use Modules\Expert\Http\Controllers\ExpertController;
use Modules\Expert\Http\Controllers\ExpertExperienceController;
use Modules\Expert\Http\Controllers\PublicExpertController;

Route::group(['prefix' => 'public/experts'], function(){
    Route::get('', [PublicExpertController::class, 'index']);
    Route::get('{id}', [PublicExpertController::class, 'show']);
    Route::post('{id}/review', [PublicExpertController::class, 'review']);
});

Route::group(['prefix' => 'experts', 'middleware' => GeneralHelper::generalExpertMiddlewares()], function(){
    Route::apiResource('experiences', ExpertExperienceController::class);

    Route::group(['prefix' => 'certification'], function(){
       Route::get('', [ExpertCertificationController::class, 'show']);
       Route::post('', [ExpertCertificationController::class, 'update']);
    });

    Route::group(['prefix' => 'me'], function(){
       Route::get('', [ExpertController::class, 'show']);
       Route::post('', [ExpertController::class, 'update']);
    });
});
