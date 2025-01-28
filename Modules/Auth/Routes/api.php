<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\PasswordController;
use Modules\Auth\Http\Controllers\PasswordResetController;
use Modules\Auth\Http\Controllers\ProfileController;
use Modules\Auth\Http\Controllers\RefreshTokenController;
use Modules\Auth\Http\Controllers\RegisterController;
use Modules\Auth\Http\Controllers\VerifyController;

Route::group(['middleware' => ['guest']], function () {
    Route::post('refresh_tokens/refresh', [AuthController::class, 'refreshToken']);
    Route::post('login', [LoginController::class, 'mobile']);

    Route::group(['prefix' => 'verify_user'], function () {
        Route::post('', [VerifyController::class, 'verify']);
        Route::post('resend', [VerifyController::class, 'send'])->middleware(['throttle:2,1']);
    });

    Route::group(['prefix' => 'password'], function () {
        Route::post('forgot_password', [PasswordResetController::class, 'forgotPassword'])->middleware(['throttle:2,1']);
        Route::post('reset_password', [PasswordResetController::class, 'resetPassword']);
        Route::post('validate_code', [PasswordResetController::class, 'validateCode']);
    });

    Route::group(['prefix' => 'register'], function(){
        Route::post('expert', [RegisterController::class, 'expert']);
        Route::post('student', [RegisterController::class, 'student']);
    });
});

Route::group(['middleware' => GeneralHelper::getDefaultLoggedUserMiddlewares()], function () {
    Route::patch('password/change_password', [PasswordController::class, 'changePassword']);
    Route::post('refresh_tokens/rotate', [RefreshTokenController::class, 'rotate']);
    Route::patch('password/change_password', [PasswordController::class, 'changePassword']);
    Route::group(['prefix' => 'profile'], function () {
        Route::get('', [ProfileController::class, 'show']);
        Route::post('', [ProfileController::class, 'handle']);
    });

    Route::post('logout', LogoutController::class);
    Route::patch('update_locale', [ProfileController::class, 'updateLocale']);
});
