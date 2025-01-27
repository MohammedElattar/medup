<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Speciality\Http\Controllers\AdminSpecialityController;

Route::group(['prefix' => 'admin/colleges/{collegeId}/specialities', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminSpecialityController::class, 'index'])->name('specialities.index');
    Route::get('create', [AdminSpecialityController::class, 'create'])->name('specialities.create');
    Route::post('', [AdminSpecialityController::class, 'store'])->name('specialities.store');
    Route::get('{id}', [AdminSpecialityController::class, 'show'])->name('specialities.show');
    Route::get('{id}', [AdminSpecialityController::class, 'edit'])->name('specialities.edit');
    Route::put('{id}', [AdminSpecialityController::class, 'update'])->name('specialities.update');
    Route::delete('{id}', [AdminSpecialityController::class, 'destroy'])->name('specialities.destroy');
});
