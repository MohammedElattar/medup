<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\AdminCategoryController;

Route::group(['prefix' => 'admin/categories', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('{id}/edit', [AdminCategoryController::class, 'show'])->name('categories.edit');
    Route::put('{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});
