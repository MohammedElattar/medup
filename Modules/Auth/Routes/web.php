<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\ProfileController;

Route::group(['middleware' => 'guest', 'prefix' => 'admin'], function () {
    Route::get('login', [LoginController::class, 'show'])->name('login')->middleware('guest');
    Route::post('login', [LoginController::class, 'dashboard'])->name('dashboard-login');
});

Route::group(['prefix' => 'admin', 'middleware' => GeneralHelper::dashboardUserMiddlewares()], function () {
    Route::post('logout', [LogoutController::class, 'dashboard'])->name('logout');
    Route::get('locale/{locale}', [ProfileController::class, 'updateDashboardLocale'])->name('change-locale');
    Route::get('profile', [ProfileController::class, 'showView'])->name('profile.show');
    Route::post('profile', [ProfileController::class, 'handle'])->name('admin.update-profile');
    Route::get('profile/change-password', [\Modules\Auth\Http\Controllers\PasswordController::class, 'edit'])->name('change-password-view');
    Route::put('profile/change-password', [\Modules\Auth\Http\Controllers\PasswordController::class, 'adminHandle'])->name('admin.update-password');
});
