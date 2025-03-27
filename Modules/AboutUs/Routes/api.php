<?php

use Illuminate\Support\Facades\Route;
use Modules\AboutUs\Http\Controllers\PublicAboutUsController;

Route::group(['prefix' => 'public/about_us'], function () {
    Route::get('', [PublicAboutUsController::class, 'index']);
    Route::get('{id}', [PublicAboutUsController::class, 'show']);
});
