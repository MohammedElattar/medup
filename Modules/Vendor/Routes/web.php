<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Vendor\Http\Controllers\VendorController;

Route::group(['prefix' => 'admin/vendors', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('create', [VendorController::class, 'create'])->name('vendors.create');
    Route::get('{id}/edit', [VendorController::class, 'show'])->name('vendors.edit');
    Route::post('', [VendorController::class, 'store'])->name('vendors.store');
    Route::post('{id}', [VendorController::class, 'update'])->name('vendors.update');
    Route::delete('{id}', [VendorController::class, 'destroy'])->name('vendors.destroy');
});
