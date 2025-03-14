<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryFileController;
use Modules\Library\Http\Controllers\PublicLibraryController;

Route::group(['prefix' => 'public/library'], function(){
    Route::get('', [PublicLibraryController::class, 'index']);
    Route::get('{id}', [PublicLibraryController::class, 'show']);

    Route::post('', [PublicLibraryController::class, 'store'])->middleware(GeneralHelper::generalExpertMiddlewares());
});

Route::group(['middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function(){
   Route::get('book_sources/{id}', [LibraryFileController::class, 'getFile']);
});
