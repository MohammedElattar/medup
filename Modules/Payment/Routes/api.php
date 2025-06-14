<?php

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Payment\Http\Controllers\AdminBankAccountController;
use Modules\Payment\Http\Controllers\BankAccountController;
use Modules\Payment\Http\Controllers\PaymentController;

Route::group([
    'middleware' => array_merge(
        GeneralHelper::getDefaultLoggedUserMiddlewares(),
        [
            'user_type_in:'.UserTypeEnum::VENDOR.'|'.UserTypeEnum::DELIVERY_MAN.'|'.UserTypeEnum::MAINTENANCE,
        ]
    ),
], function () {
    Route::patch('payments/bank_accounts/{id}/make_default', [BankAccountController::class, 'makeDefault']);
    Route::post('payments/bank_accounts/{id}', [BankAccountController::class, 'update']);
    Route::apiResource('payments/bank_accounts', BankAccountController::class)->except('update');
});

Route::group(['prefix' => 'admin/external_users/{userId}/payments/bank_accounts', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminBankAccountController::class, 'index']);
    Route::get('{id}', [AdminBankAccountController::class, 'show']);
});

Route::post('payments/webhook', [PaymentController::class, 'processWebhook']);