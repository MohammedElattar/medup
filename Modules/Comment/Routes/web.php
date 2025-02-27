<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\AdminCommentController;

Route::group(['prefix' => 'admin/comments', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::get('{id}', [AdminCommentController::class, 'show'])->name('comments.show');
    Route::delete('{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
});
