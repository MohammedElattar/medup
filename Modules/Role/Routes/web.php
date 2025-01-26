<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Role\Helpers\PermissionHelper;
use Modules\Role\Http\Controllers\AdminRoleController;

Route::group(['prefix' => 'admin/roles', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminRoleController::class, 'index'])
        ->name('roles.index')
        ->middleware(PermissionHelper::getPermissionNameMiddleware('all', 'role'));

    Route::get('create', [AdminRoleController::class, 'create'])
        ->middleware(PermissionHelper::getPermissionNameMiddleware('store', 'role'))
        ->name('roles.create');

    Route::get('{id}', [AdminRoleController::class, 'show'])
        ->name('roles.edit')
        ->middleware(PermissionHelper::getPermissionNameMiddleware('update', 'role'));

    Route::post('', [AdminRoleController::class, 'store'])
        ->name('roles.store');

    Route::put('{id}', [AdminRoleController::class, 'update'])
        ->name('roles.update');

    Route::delete('{id}', [AdminRoleController::class, 'destroy'])
        ->middleware(PermissionHelper::getPermissionNameMiddleware('delete', 'role'))
        ->name('roles.destroy');
});
