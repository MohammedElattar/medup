<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\PasswordController;
use Modules\Auth\Http\Controllers\ProfileController;
use Modules\Auth\Http\Controllers\RefreshTokenController;

Route::group(['middleware' => ['guest']], function () {
    Route::post('refresh_tokens/refresh', [AuthController::class, 'refreshToken']);
    Route::post('login/mobile', [LoginController::class, 'mobile']);
});
Route::group(['middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
    Route::post('refresh_tokens/rotate', [RefreshTokenController::class, 'rotate']);
    Route::patch('password/change_password', [PasswordController::class, 'changePassword']);
    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [ProfileController::class, 'show']);
        Route::post('', [ProfileController::class, 'handle']);
    });

    Route::post('logout', LogoutController::class);
});
