<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\AboutUs\Http\Controllers\AdminAboutUsController;

Route::group(['prefix' => 'admin/about-us', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminAboutUsController::class, 'index'])->name('about_us.index');
    Route::get('{id}', [AdminAboutUsController::class, 'show'])->name('about_us.show');
    Route::post('{id}', [AdminAboutUsController::class, 'update'])->name('about_us.update');
});
