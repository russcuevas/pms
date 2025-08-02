<?php

use App\Http\Controllers\host\HostAuthController;
use App\Http\Controllers\host\HostHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// HOST ROUTES
// HOST AUTH
Route::get('/host/login', [HostAuthController::class, 'HostLoginPage'])->name('host.login.page');


// HOST DASHBOARD
Route::get('/host/home', [HostHomeController::class, 'HostHomePage'])->name('host.home.page');
