<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\PublicCommentController;

Route::group(['prefix' => 'public/comments'], function(){
   Route::get('', [PublicCommentController::class, 'index']);

   Route::group(['middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function(){
       Route::post('', [PublicCommentController::class, 'store']);
       Route::delete('{id}', [PublicCommentController::class, 'destroy']);
   });
});
