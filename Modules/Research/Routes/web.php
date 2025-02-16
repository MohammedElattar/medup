<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Research\Http\Controllers\AdminResearchController;

Route::group(['prefix' => 'admin/researches', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminResearchController::class, 'index'])->name('researches.index');
    Route::delete('{id}', [AdminResearchController::class, 'destroy'])->name('researches.delete');
});
