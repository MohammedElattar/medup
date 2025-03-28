<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\PublicSettingController;

Route::group(['prefix' => 'public/settings'], function(){
    Route::get('', [PublicSettingController::class, 'show']);
});
