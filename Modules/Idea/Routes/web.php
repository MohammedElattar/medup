<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Idea\Http\Controllers\AdminIdeaController;

Route::group(['prefix' => 'admin/ideas', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminIdeaController::class, 'index'])->name('ideas.index');
    Route::get('{id}', [AdminIdeaController::class, 'edit'])->name('ideas.edit');
    Route::get('{id}/change_status', [AdminIdeaController::class, 'changeStatus'])->name('ideas.change_status');
    Route::delete('{id}', [AdminIdeaController::class, 'destroy'])->name('ideas.destroy');
});
