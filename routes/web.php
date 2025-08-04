<?php

use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\hubert\DashboardController as HubertDashboardController;
use App\Http\Controllers\admin\jjs1\DashboardController as AdminJjs1DashboardController;
use App\Http\Controllers\admin\jjs2\DashboardController as AdminJjs2DashboardController;
use App\Http\Controllers\host\HostAuthController;
use App\Http\Controllers\host\HostHomeController;
use App\Http\Controllers\host\hubert\AdminController;
use App\Http\Controllers\host\hubert\BillingController;
use App\Http\Controllers\host\hubert\DashboardController;
use App\Http\Controllers\host\jjs1\DashboardController as Jjs1DashboardController;
use App\Http\Controllers\host\jjs2\DashboardController as Jjs2DashboardController;
use App\Http\Controllers\tenant\hubert\DashboardController as TenantHubertDashboardController;
use App\Http\Controllers\tenant\jjs1\DashboardController as TenantJjs1DashboardController;
use App\Http\Controllers\tenant\jjs2\DashboardController as TenantJjs2DashboardController;
use App\Http\Controllers\tenant\TenantAuthController;
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

// ADMIN MANAGEMENT
Route::get('/host/huberts/admin-management', [AdminController::class, 'HostHubertAdminPage'])->name('host.huberts.admin.management.page');
Route::patch('/host/hubert/admin-management/update-approval/{id}', [AdminController::class, 'HostHubertUpdateApproval'])->name('host.hubert.update.admin.approval');


// JJS1
Route::get('/host/jjs1/dashboard', [Jjs1DashboardController::class, 'HostJjs1DashboardPage'])->name('host.jjs1.dashboard.page');

// JJS2
Route::get('/host/jjs2/dashboard', [Jjs2DashboardController::class, 'HostJjs2DashboardPage'])->name('host.jjs2.dashboard.page');



// ADMIN ROUTES
// ADMIN AUTH
Route::get('/admin/login', [AdminAuthController::class, 'AdminLoginPage'])->name('admin.login.page');
Route::post('/admin/login/request', [AdminAuthController::class, 'AdminLoginRequest'])->name('admin.login.request');
Route::get('/admin/logout/request', [AdminAuthController::class, 'AdminLogoutRequest'])->name('admin.logout.request');

Route::get('/admin/register', [AdminAuthController::class, 'AdminRegisterPage'])->name('admin.register.page');
Route::post('/admin/register/request', [AdminAuthController::class, 'AdminRegisterRequest'])->name('admin.register.request');



// HUBERTS
Route::get('/admin/huberts/dashboard', [HubertDashboardController::class, 'AdminHubertDashboardPage'])->name('admin.huberts.dashboard.page');

// JJS1
Route::get('/admin/jjs1/dashboard', [AdminJjs1DashboardController::class, 'AdminJjs1DashboardPage'])->name('admin.jjs1.dashboard.page');

// JJS2
Route::get('/admin/jjs2/dashboard', [AdminJjs2DashboardController::class, 'AdminJjs2DashboardPage'])->name('admin.jjs2.dashboard.page');






// TENANTS ROUTES
// TENANT AUTH
Route::get('/tenants/login', [TenantAuthController::class, 'TenantsLoginPage'])->name('tenants.login.page');
Route::post('/tenants/login/request', [TenantAuthController::class, 'TenantsLoginRequest'])->name('tenants.login.request');
Route::get('/tenants/logout/request', [TenantAuthController::class, 'TenantsLogoutRequest'])->name('tenants.logout.request');


// HUBERTS
Route::get('/tenants/huberts/dashboard', [TenantHubertDashboardController::class, 'TenantsHubertDashboardPage'])->name('tenants.huberts.dashboard.page');
// JJS1
Route::get('/tenants/jjs1/dashboard', [TenantJjs1DashboardController::class, 'TenantsJjs1DashboardPage'])->name('tenants.jjs1.dashboard.page');
// JJS2
Route::get('/tenants/jjs2/dashboard', [TenantJjs2DashboardController::class, 'TenantsJjs2DashboardPage'])->name('tenants.jjs2.dashboard.page');
