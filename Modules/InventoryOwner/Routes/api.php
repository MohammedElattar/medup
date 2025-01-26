<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\InventoryOwner\Http\Controllers\PublicInventoryOwnerController;

Route::group(['prefix' => 'public/inventory-owners', 'middleware' => GeneralHelper::vendorMiddlewares()], function () {
    Route::get('', [PublicInventoryOwnerController::class, 'index']);
});
