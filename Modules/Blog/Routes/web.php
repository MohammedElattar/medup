<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\AdminBlogController;

Route::group(['prefix' => 'admin/blogs', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminBlogController::class, 'index'])->name('blogs.index');
    Route::get('create', [AdminBlogController::class, 'create'])->name('blogs.create');
    Route::post('', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::get('{college}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
    Route::post('{college}', [AdminBlogController::class, 'update'])->name('blogs.update');
    Route::delete('{college}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
});
