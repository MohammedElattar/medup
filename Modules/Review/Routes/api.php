<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Review\Http\Controllers\AdminRatingController;
use Modules\Review\Http\Controllers\ClientReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'admin/reviews', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminRatingController::class, 'index']);
    Route::delete('{id}', [AdminRatingController::class, 'destroy']);
    Route::patch('{id}', [AdminRatingController::class, 'changePublic']);
});

Route::get('public/reviews', [ClientReviewController::class, 'index']);
