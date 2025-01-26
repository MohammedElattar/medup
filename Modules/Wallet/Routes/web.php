<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Wallet\Http\Controllers\TransactionController;
use Modules\Wallet\Http\Controllers\WalletController;

Route::group(['middleware' => GeneralHelper::dashboardUserMiddlewares(), 'prefix' => 'admin'], function () {
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
//    Route::group(['prefix' => 'users/{id}', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
//        Route::get('wallet', [WalletController::class, 'show']);
//        Route::get('wallet/reset', [WalletController::class, 'reset']);
//        Route::get('transactions', [TransactionController::class, 'index']);
//    });
//
//    Route::group(['prefix' => 'transactions', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
//        Route::get('', [TransactionController::class, 'index']);
//    });
//
//    Route::group(['prefix' => 'wallet', 'middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
//        Route::get('', [WalletController::class, 'show']);
//        Route::post('deposit', [WalletController::class, 'deposit']);
//    });
//
//    Route::group(['prefix' => 'wallet', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
//        Route::post('transfer', [WalletController::class, 'transfer']);
//        Route::post('deposit', [WalletController::class, 'deposit']);
//    });
});
