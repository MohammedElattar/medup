<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Research\Http\Controllers\PublicResearchController;

Route::group(['prefix' => 'public/researches', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function(){
    Route::post('', [PublicResearchController::class, 'store']);
});
