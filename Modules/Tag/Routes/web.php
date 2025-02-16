<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\TagController;

Route::group(['prefix' => 'admin/tags', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [TagController::class, 'index'])->name('tags.index');
    Route::get('create', [TagController::class, 'create'])->name('tags.create');
    Route::post('', [TagController::class, 'store'])->name('tags.store');
    Route::get('{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
});
