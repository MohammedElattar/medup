<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Collaborate\Http\Controllers\AdminCollaborateController;

Route::group(['prefix' => 'admin/collaborates', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminCollaborateController::class, 'index'])->name('collaborates.index');
    Route::get('{id}', [AdminCollaborateController::class, 'edit'])->name('collaborates.edit');
    Route::get('{id}/change_status', [AdminCollaborateController::class, 'changeStatus'])->name('collaborates.change_status');
    Route::delete('{id}', [AdminCollaborateController::class, 'destroy'])->name('collaborates.destroy');
});
