<?php

use App\Http\Controllers\SelectMenuController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/select_menu'], function(){
    Route::get('countries', [SelectMenuController::class, 'countries']);
    Route::get('cities', [SelectMenuController::class, 'cities']);
    Route::get('skills', [SelectMenuController::class, 'skills']);
    Route::get('colleges', [SelectMenuController::class, 'colleges']);
    Route::get('specialities', [SelectMenuController::class, 'specialities']);
    Route::get('colleges_with_specialities', [SelectMenuController::class, 'collegesWithSpecialities']);
});

Route::get('test_event', function(){
    broadcast(new \App\Events\TestingEvent());
});
