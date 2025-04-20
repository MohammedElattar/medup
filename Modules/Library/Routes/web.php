<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\AdminLibraryController;

Route::group(['prefix' => 'admin/library', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [AdminLibraryController::class, 'index'])->name('library.index');
    Route::delete('{id}', [AdminLibraryController::class, 'destroy'])->name('library.destroy');
});
