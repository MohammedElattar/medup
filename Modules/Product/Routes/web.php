<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\AdminProductController;

Route::group(['prefix' => 'admin/products', 'middleware' => GeneralHelper::dashboardUserMiddlewares()], function () {
    Route::get('', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::post('{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});
