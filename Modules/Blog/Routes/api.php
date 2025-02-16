<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\PublicBlogController;

Route::group(['prefix' => 'public/blogs'], function(){
   Route::get('', [PublicBlogController::class, 'index']);
});
