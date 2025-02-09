<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\College\Http\Controllers\AdminCollegeController;

Route::group(['prefix' => 'admin/colleges', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminCollegeController::class, 'index'])->name('colleges.index');
    Route::get('create', [AdminCollegeController::class, 'create'])->name('colleges.create');
    Route::post('', [AdminCollegeController::class, 'store'])->name('colleges.store');
    Route::get('{college}/edit', [AdminCollegeController::class, 'edit'])->name('colleges.edit');
    Route::post('{college}', [AdminCollegeController::class, 'update'])->name('colleges.update');
    Route::delete('{college}', [AdminCollegeController::class, 'destroy'])->name('colleges.destroy');
});
