<?php

use Illuminate\Support\Facades\Route;
use Modules\Skill\Http\Controllers\PublicSkillController;

Route::group(['prefix' => 'public/skills'], function(){
   Route::get('', [PublicSkillController::class, 'index']);
});
