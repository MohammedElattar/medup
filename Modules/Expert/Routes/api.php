<?php

use Illuminate\Support\Facades\Route;
use Modules\Expert\Http\Controllers\PublicExpertController;

Route::group(['prefix' => 'public/experts'], function(){
    Route::get('', [PublicExpertController::class, 'index']);
});
