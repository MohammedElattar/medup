<?php

use Illuminate\Support\Facades\Route;
use Modules\College\Http\Controllers\PublicCollegeController;

Route::group(['prefix' => 'public/colleges'], function(){
   Route::get('', [PublicCollegeController::class, 'index']);
});
