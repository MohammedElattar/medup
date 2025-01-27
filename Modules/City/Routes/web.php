<?php

use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Route;
use Modules\City\Http\Controllers\CityController;

Route::group(['prefix' => 'admin/countries/{countryId}/cities', 'middleware' => GeneralHelper::adminMiddlewares()], function(){
    Route::get('', [CityController::class, 'index'])->name('cities.index');
    Route::get('create', [CityController::class, 'create'])->name('cities.create');
    Route::post('', [CityController::class, 'store'])->name('cities.store');
    Route::get('{id}', [CityController::class, 'show'])->name('cities.show');
    Route::get('{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::put('{id}', [CityController::class, 'update'])->name('cities.update');
    Route::delete('{id}', [CityController::class, 'destroy'])->name('cities.destroy');
});
