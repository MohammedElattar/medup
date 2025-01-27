<?php

use App\Helpers\GeneralHelper;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Main Page Route

/* Route Dashboards */

/* Route Apps */

Route::group(['middleware' => GeneralHelper::dashboardUserMiddlewares()], function () {
    Route::get('/', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');
});
