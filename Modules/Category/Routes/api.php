<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\PublicCategoryController;

Route::group(['prefix' => 'public/categories', 'middleware' => GeneralHelper::vendorMiddlewares()], function () {
    Route::get('', [PublicCategoryController::class, 'index']);
});
