<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\Country\Http\Controllers\CountryController;

Route::group(['prefix' => 'admin/countries', 'middleware' => GeneralHelper::adminMiddlewares()], function () {
    Route::get('', [CountryController::class, 'index'])->name('countries.index');
    Route::get('create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('', [CountryController::class, 'store'])->name('countries.store');
    Route::get('{country}/edit', [CountryController::class, 'edit'])->name('countries.edit');
    Route::put('{country}', [CountryController::class, 'update'])->name('countries.update');
    Route::delete('{country}', [CountryController::class, 'destroy'])->name('countries.destroy');
});
