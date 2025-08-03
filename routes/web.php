<?php

use App\Http\Controllers\host\HostAuthController;
use App\Http\Controllers\host\HostHomeController;
use App\Http\Controllers\host\hubert\BillingController;
use App\Http\Controllers\host\hubert\DashboardController;
use App\Http\Controllers\host\jjs1\DashboardController as Jjs1DashboardController;
use App\Http\Controllers\host\jjs2\DashboardController as Jjs2DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// HOST ROUTES
// HOST AUTH
Route::get('/host/login', [HostAuthController::class, 'HostLoginPage'])->name('host.login.page');
Route::post('/host/login/request', [HostAuthController::class, 'HostLoginRequest'])->name('host.login.request');
Route::get('/host/logout/request', [HostAuthController::class, 'HostLogoutRequest'])->name('host.logout.request');

// HOST DASHBOARD
Route::get('/host/home', [HostHomeController::class, 'HostHomePage'])->name('host.home.page');

// HOST DIFFERENT PROPERTIES

// HUBERTS
Route::get('/host/huberts/dashboard', [DashboardController::class, 'HostHubertDashboardPage'])->name('host.huberts.dashboard.page');
Route::get('/host/huberts/billing', [BillingController::class, 'HostHubertBillingPage'])->name('host.huberts.billing.page');

// JJS1
Route::get('/host/jjs1/dashboard', [Jjs1DashboardController::class, 'HostJjs1DashboardPage'])->name('host.jjs1.dashboard.page');

// JJS2
Route::get('/host/jjs2/dashboard', [Jjs2DashboardController::class, 'HostJjs2DashboardPage'])->name('host.jjs2.dashboard.page');
