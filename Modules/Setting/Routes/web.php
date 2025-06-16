<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\AdminSettingController;

Route::group(['prefix' => 'admin/settings', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminSettingController::class, 'show'])->name('settings.show');
    Route::put('', [AdminSettingController::class, 'update'])->name('settings.update');
});
