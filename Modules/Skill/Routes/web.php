<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Skill\Http\Controllers\AdminSkillController;

Route::group(['prefix' => 'admin/skills', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [AdminSkillController::class, 'index'])->name('skills.index');
    Route::get('create', [AdminSkillController::class, 'create'])->name('skills.create');
    Route::post('', [AdminSkillController::class, 'store'])->name('skills.store');
    Route::get('{id}', [AdminSkillController::class, 'show'])->name('skills.edit');
    Route::post('{id}', [AdminSkillController::class, 'update'])->name('skills.update');
    Route::delete('{id}', [AdminSkillController::class, 'destroy'])->name('skills.destroy');
});
