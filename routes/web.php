<?php

// HOST
use App\Http\Controllers\host\HostAuthController;
use App\Http\Controllers\host\HostHomeController;
use App\Http\Controllers\host\hubert\AdminController;
use App\Http\Controllers\host\hubert\BillingController;
use App\Http\Controllers\host\hubert\DashboardController;
use App\Http\Controllers\host\hubert\ExpensesController as HubertExpensesController;
use App\Http\Controllers\host\hubert\PaymentsController as HubertPaymentsController;
use App\Http\Controllers\host\hubert\RequestController as HostHubertRequestController;
use App\Http\Controllers\host\hubert\TurnOverController;
use App\Http\Controllers\host\jjs1\DashboardController as Jjs1DashboardController;
use App\Http\Controllers\host\jjs2\DashboardController as Jjs2DashboardController;

// ADMIN
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\admin\hubert\AnnouncementController;
use App\Http\Controllers\admin\hubert\BillingController as HubertBillingController;
use App\Http\Controllers\admin\hubert\DashboardController as HubertDashboardController;
use App\Http\Controllers\admin\hubert\ExpensesController;
use App\Http\Controllers\admin\hubert\PaymentsController;
use App\Http\Controllers\admin\hubert\RequestController as HubertRequestController;
use App\Http\Controllers\admin\hubert\UnitsController;
use App\Http\Controllers\admin\jjs1\DashboardController as AdminJjs1DashboardController;
use App\Http\Controllers\admin\jjs2\DashboardController as AdminJjs2DashboardController;
use App\Http\Controllers\host\hubert\AnnouncementController as HubertAnnouncementController;
use App\Http\Controllers\tenant\hubert\AnnouncementController as TenantHubertAnnouncementController;
// TENANTS
use App\Http\Controllers\tenant\hubert\DashboardController as TenantHubertDashboardController;
use App\Http\Controllers\tenant\hubert\PaymentController;
use App\Http\Controllers\tenant\hubert\RequestController;
use App\Http\Controllers\tenant\hubert\ViewBillingController;
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

// TURNOVERS
Route::get('/host/huberts/turnovers', [TurnOverController::class, 'TurnOverPage'])->name('host.huberts.turnover.page');
Route::post('/turnovers/{id}/approve', [TurnOverController::class, 'TurnOverApproveRequest'])->name('host.huberts.turnovers.approve');
Route::delete('/turnovers/{id}/decline', [TurnOverController::class, 'TurnOverDeclineRequest'])->name('host.huberts.turnovers.decline');

// EXPENSES
Route::get('/host/huberts/expenses', [HubertExpensesController::class, 'HostHubertExpensesPage'])->name('host.huberts.expenses.page');
Route::post('/host/hubert/expenses/{id}/approve', [HubertExpensesController::class, 'HostHubertApprovedRequest'])->name('host.hubert.expenses.approve');
Route::delete('/host/hubert/expenses/{id}/decline', [HubertExpensesController::class, 'HostHubertDeclineRequest'])->name('host.hubert.expenses.decline');

// BILLING MANAGEMENT
Route::get('/host/huberts/previous-billings/{tenantId}', [BillingController::class, 'HostHubertViewPreviousBillings'])->name('host.huberts.previous.billings');
Route::get('/host/huberts/billing', [BillingController::class, 'HostHubertBillingPage'])->name('host.huberts.billing.page');
// ADMIN MANAGEMENT
Route::get('/host/huberts/admin-management', [AdminController::class, 'HostHubertAdminPage'])->name('host.huberts.admin.management.page');
Route::patch('/host/hubert/admin-management/update-approval/{id}', [AdminController::class, 'HostHubertUpdateApproval'])->name('host.hubert.update.admin.approval');
// PAYMENTS MANAGEMENT
Route::get('/host/hubert/payments', [HubertPaymentsController::class, 'HostHubertPaymentsPage'])->name('host.huberts.payments.page');
Route::post('/host/hubert/payments/approve/{paymentId}', [HubertPaymentsController::class, 'HostHubertApprovePayment'])->name('host.huberts.payments.approve');
Route::post('/host/hubert/payments/decline/{paymentId}', [HubertPaymentsController::class, 'HostHubertDeclinePayment'])->name('host.huberts.payments.decline');
// REQUEST MANAGENENT
Route::get('/host/hubert/request-management', [HostHubertRequestController::class, 'HostHubertRequestPage'])->name('host.huberts.request.page');
Route::patch('/host/hubert/request/{id}/address', [HostHubertRequestController::class, 'HostHubertRequestAddressRequest'])
    ->name('host.hubert.request.address');
Route::delete('/host/hubert/request/{id}/delete', [HostHubertRequestController::class, 'HostHubertRequestAddressRequest'])
    ->name('host.hubert.request.delete');
// ANNOUNCEMENT MANAGEMENT
Route::get('/host/hubert/announcement-management', [HubertAnnouncementController::class, 'HostHubertAnnouncementPage'])->name('host.huberts.announcement.page');
Route::post('/host/hubert/announcements/{id}/approve', [HubertAnnouncementController::class, 'HostHubertAnnouncementApprove'])->name('host.hubert.announcements.approve');
Route::post('/host/hubert/announcements/{id}/decline', [HubertAnnouncementController::class, 'HostHubertAnnouncementDecline'])->name('host.hubert.announcements.decline');
Route::post('/host/hubert/announcements/{id}/delete', [HubertAnnouncementController::class, 'HostHubertAnnouncementDelete'])->name('host.hubert.announcements.delete');
// END HUBERTS


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
// END ADMIN AUTH


// HUBERTS

// HUBERTS DASHBOARD
Route::get('/admin/huberts/dashboard', [HubertDashboardController::class, 'AdminHubertDashboardPage'])->name('admin.huberts.dashboard.page');
Route::post('/admin/huberts/turn-over', [HubertDashboardController::class, 'AdminHubertTurnOverMoney'])->name('admin.huberts.turnover.request');
// END HUBERTS DASHBOARD

// HUBERTS EXPENSES
Route::get('/admin/huberts/expenses', [ExpensesController::class, 'AdminHubertExpensesPage'])->name('admin.huberts.expenses.page');
Route::post('/admin/huberts/expenses/create', [ExpensesController::class, 'AdminHubertExpensesRequest'])->name('admin.huberts.expenses.request');


// HUBERTS UNIT MANAGEMENT PAGE
Route::get('admin/huberts/unit_management', [UnitsController::class, 'AdminUnitsManagementPage'])->name('admin.huberts.units.management.page');
Route::post('/admin/huberts/units/transfer-and-repair', [UnitsController::class, 'AdminHubertTransferAndRepair'])->name('admin.units.transfer-and-repair');
Route::post('/admin/huberts/units/mark-for-repair', [UnitsController::class, 'AdminHubertMarkForRepair'])->name('admin.units.mark-for-repair');
Route::post('/admin/huberts/units/mark-as-repaired', [UnitsController::class, 'AdminHubertMarkAsRepaired'])->name('admin.units.mark-as-repaired');
Route::post('/admin/huberts/unit/{unit}/moveout/{tenant}', [UnitsController::class, 'AdminHubertMoveOutTenant'])->name('admin.units.moveout');

// HUBERTS BILLING PAGE
Route::get('/admin/hubert/billing', [HubertBillingController::class, 'AdminHubertBillingPage'])->name('admin.hubert.billing.page');
Route::post('/admin/hubert/billing/create', [HubertBillingController::class, 'AdminHubertBillingCreate'])->name('admin.hubert.billing.create');

// HUBERTS PAYMENT PAGE
Route::get('/admin/hubert/payments/create', [PaymentsController::class, 'AdminHubertPaymentPage'])->name('admin.hubert.payments.page');
Route::post('/admin/hubert/payments/store', [PaymentsController::class, 'AdminHubertPaymentRequest'])->name('admin.hubert.payments.request');

// HUBERTS REQUEST PAGE
Route::get('/admin/hubert/request_management', [HubertRequestController::class, 'AdminHubertRequestPage'])->name('admin.hubert.request.page');
Route::put('/admin/hubert/request/{id}/approve', [HubertRequestController::class, 'AdminHubertRequestApprove'])->name('admin.hubert.request.approve');
Route::delete('/admin/hubert/request/{id}/decline', [HubertRequestController::class, 'AdminHubertRequestDecline'])->name('admin.hubert.request.decline');


// HUBERTS ANNOUNCEMENT PAGE
Route::get('/admin/hubert/announcement_management', [AnnouncementController::class, 'AdminHubertAnnouncementPage'])->name('admin.hubert.announcement.page');
Route::post('/admin/hubert/announcement/request', [AnnouncementController::class, 'AdminHubertAnnouncementRequest'])->name('admin.hubert.announcement.request');


// JJS1
Route::get('/admin/jjs1/dashboard', [AdminJjs1DashboardController::class, 'AdminJjs1DashboardPage'])->name('admin.jjs1.dashboard.page');

// JJS2
Route::get('/admin/jjs2/dashboard', [AdminJjs2DashboardController::class, 'AdminJjs2DashboardPage'])->name('admin.jjs2.dashboard.page');






// TENANTS ROUTES
// TENANT AUTH
Route::get('/tenants/login', [TenantAuthController::class, 'TenantsLoginPage'])->name('tenants.login.page');
Route::post('/tenants/login/request', [TenantAuthController::class, 'TenantsLoginRequest'])->name('tenants.login.request');
Route::get('/tenants/logout/request', [TenantAuthController::class, 'TenantsLogoutRequest'])->name('tenants.logout.request');

Route::get('/tenants/register', [TenantAuthController::class, 'TenantsRegisterPage'])->name('tenants.register.page');
Route::post('/tenants/register/request', [TenantAuthController::class, 'TenantsRegisterRequest'])->name('tenants.register.request');

Route::get('/tenants/verify-otp', [TenantAuthController::class, 'TenantsOtpPage'])->name('tenants.otp.page');
Route::post('/tenants/verify-otp/request', [TenantAuthController::class, 'TenantsVerifyOtp'])->name('tenants.verify.otp');


// TENANTS HUBERTS
Route::get('/tenants/huberts/dashboard', [TenantHubertDashboardController::class, 'TenantsHubertDashboardPage'])->name('tenants.huberts.dashboard.page');

// TENANTS HUBERTS BILLING PAGE
Route::get('/tenants/huberts/my-billing', [ViewBillingController::class, 'TenantsHubertMyBillingPage'])->name('tenants.huberts.my-billing.page');

// TENANTS HUBERTS PAYMENT PAGE
Route::get('/tenants/huberts/my-payment', [PaymentController::class, 'TenantsHubertMyPaymentPage'])->name('tenants.huberts.my-payment.page');

// TENANTS HUBERTS REQUEST PAGE
Route::get('/tenants/huberts/my-request', [RequestController::class, 'TenantsHubertMyRequestPage'])->name('tenants.huberts.my-request.page');
Route::post('/tenants/huberts/my-request/post', [RequestController::class, 'TenantsHubertRequestPost'])->name('tenants.huberts.my-request.post');

// TENANTS HUBERTS ANNOUNCEMENT PAGE
Route::get('/tenants/huberts/announcements', [TenantHubertAnnouncementController::class, 'TenantsHubertAnnouncementPage'])->name('tenants.huberts.announcement.page');


// JJS1
Route::get('/tenants/jjs1/dashboard', [TenantJjs1DashboardController::class, 'TenantsJjs1DashboardPage'])->name('tenants.jjs1.dashboard.page');
// JJS2
Route::get('/tenants/jjs2/dashboard', [TenantJjs2DashboardController::class, 'TenantsJjs2DashboardPage'])->name('tenants.jjs2.dashboard.page');
