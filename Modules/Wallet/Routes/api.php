<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\TransactionController;
use Modules\Wallet\Http\Controllers\WalletController;

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
Route::group(['middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
    Route::group(['prefix' => 'users/{id}', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
        Route::get('wallet', [WalletController::class, 'show']);
        Route::get('wallet/reset', [WalletController::class, 'reset']);
        Route::get('transactions', [TransactionController::class, 'index']);
    });

    Route::group(['prefix' => 'transactions'], function () {
        Route::get('', [TransactionController::class, 'index']);
    });

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('', [WalletController::class, 'show']);
        Route::post('withdrawal', [WalletController::class, 'withdrawal']);
        Route::post('deposit', [WalletController::class, 'deposit']);
        Route::post('transfer', [WalletController::class, 'transfer']);
    });

//    Route::group(['prefix' => 'wallet', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
//        Route::post('transfer', [WalletController::class, 'transfer']);
//        Route::post('deposit', [WalletController::class, 'deposit']);
//    });
});
