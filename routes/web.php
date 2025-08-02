<?php

use App\Http\Controllers\host\HostAuthController;
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
Route::get('/host/login', [HostAuthController::class, 'HostLoginPage'])->name('host.login.page');
