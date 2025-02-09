<?php

use Illuminate\Support\Facades\Route;
use Modules\Testimonial\Http\Controllers\PublicTestimonialController;

Route::group(['prefix' => 'public/testimonials'], function(){
    Route::get('', [PublicTestimonialController::class, 'index']);
});
