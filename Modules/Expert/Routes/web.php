<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Expert\Http\Controllers\AdminExpertController;

Route::group(['prefix' => 'admin/users', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminExpertController::class, 'index'])->name('experts.index');
    Route::get('{id}/change_status', [AdminExpertController::class, 'changeStatus'])->name('experts.change_status');
//    Route::delete('{id}', [AdminExpertController::class, 'destroy'])->name('experts.destroy');
});
