<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\InventoryOwner\Http\Controllers\InventoryOwnerController;

Route::group(['prefix' => 'admin/inventory-owners', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [InventoryOwnerController::class, 'index'])->name('inventory-owners.index');
    Route::get('create', [InventoryOwnerController::class, 'create'])->name('inventory-owners.create');
    Route::get('{id}/edit', [InventoryOwnerController::class, 'show'])->name('inventory-owners.edit');
    Route::post('', [InventoryOwnerController::class, 'store'])->name('inventory-owners.store');
    Route::post('{id}', [InventoryOwnerController::class, 'update'])->name('inventory-owners.update');
    Route::delete('{id}', [InventoryOwnerController::class, 'destroy'])->name('inventory-owners.destroy');
});
