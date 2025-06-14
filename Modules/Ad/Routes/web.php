<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\AdminAdController;

Route::group(['prefix' => 'admin/ads', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminAdController::class, 'index'])->name('ads.index');
    Route::post('', [AdminAdController::class, 'store'])->name('ads.store');
    Route::get('create', [AdminAdController::class, 'create'])->name('ads.create');
    Route::get('{id}', [AdminAdController::class, 'show'])->name('ads.edit');
    Route::post('{id}', [AdminAdController::class, 'update'])->name('ads.update');
    Route::delete('{id}', [AdminAdController::class, 'destroy'])->name('ads.destroy');
});
