<?php

use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\PublicAdController;

Route::group(['prefix' => 'public/ads'], function () {
    Route::get('', [PublicAdController::class, 'index']);
});
