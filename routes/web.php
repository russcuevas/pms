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
use App\Http\Controllers\admin\hubert\BalanceController as HubertBalanceController;
use App\Http\Controllers\admin\hubert\BillingController as HubertBillingController;
use App\Http\Controllers\admin\hubert\DashboardController as HubertDashboardController;
use App\Http\Controllers\admin\hubert\ExpensesController;
use App\Http\Controllers\admin\hubert\PaymentProofController as HubertPaymentProofController;
use App\Http\Controllers\admin\hubert\PaymentsController;
use App\Http\Controllers\admin\hubert\RequestController as HubertRequestController;
use App\Http\Controllers\admin\hubert\RequestToManagerController;
use App\Http\Controllers\admin\hubert\UnitsController;
use App\Http\Controllers\admin\jjs1\DashboardController as AdminJjs1DashboardController;
use App\Http\Controllers\admin\jjs2\DashboardController as AdminJjs2DashboardController;
use App\Http\Controllers\host\hubert\AnnouncementController as HubertAnnouncementController;
use App\Http\Controllers\host\hubert\BalanceController;
use App\Http\Controllers\host\hubert\PaymentProofController as HostHubertPaymentProofController;
use App\Http\Controllers\host\hubert\RequestToManagerController as HubertRequestToManagerController;
use App\Http\Controllers\tenant\hubert\AnnouncementController as TenantHubertAnnouncementController;
// TENANTS
use App\Http\Controllers\tenant\hubert\DashboardController as TenantHubertDashboardController;
use App\Http\Controllers\tenant\hubert\NotificationController;
use App\Http\Controllers\tenant\hubert\PaymentController;
use App\Http\Controllers\tenant\hubert\PaymentProofController;
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

// HUBERTS LEFT SIDEBAR
// HUBERTS
Route::get('/host/huberts/dashboard', [DashboardController::class, 'HostHubertDashboardPage'])->name('host.huberts.dashboard.page');

// ADMIN MANAGEMENT
Route::get('/host/huberts/admin-management', [AdminController::class, 'HostHubertAdminPage'])->name('host.huberts.admin.management.page');
Route::patch('/host/hubert/admin-management/update-approval/{id}', [AdminController::class, 'HostHubertUpdateApproval'])->name('host.hubert.update.admin.approval');

// TURNOVERS
Route::get('/host/huberts/turnovers', [TurnOverController::class, 'TurnOverPage'])->name('host.huberts.turnover.page');
Route::post('/turnovers/{id}/approve', [TurnOverController::class, 'TurnOverApproveRequest'])->name('host.huberts.turnovers.approve');
Route::delete('/turnovers/{id}/decline', [TurnOverController::class, 'TurnOverDeclineRequest'])->name('host.huberts.turnovers.decline');

// ADMIN REQUEST
Route::get('/host/hubert/admin-request', [HubertRequestToManagerController::class, 'HostHubertRequestToManagerPage'])->name('host.huberts.request_to_manager.page');
Route::patch('/host/hubert/request-to-manager/{id}/approve', [HubertRequestToManagerController::class, 'HostHubertRequestToManagerApprove'])
    ->name('host.hubert.request_to_manager.approve');
Route::delete('/host/hubert/request-to-manager/{id}/decline', [HubertRequestToManagerController::class, 'HostHubertRequestToManagerDecline'])
    ->name('host.hubert.request_to_manager.decline');
Route::delete('/host/hubert/request-to-manager/{id}/delete', [HubertRequestToManagerController::class, 'HostHubertRequestToManagerDelete'])
    ->name('host.hubert.request_to_manager.delete');


// BILLING MANAGEMENT
Route::get('/host/huberts/previous-billings/{tenantId}', [BillingController::class, 'HostHubertViewPreviousBillings'])->name('host.huberts.previous.billings');
Route::get('/host/huberts/billing', [BillingController::class, 'HostHubertBillingPage'])->name('host.huberts.billing.page');

// PAYMENTS MANAGEMENT
Route::get('/host/hubert/payments', [HubertPaymentsController::class, 'HostHubertPaymentsPage'])->name('host.huberts.payments.page');
Route::post('/host/hubert/payments/approve/{paymentId}', [HubertPaymentsController::class, 'HostHubertApprovePayment'])->name('host.huberts.payments.approve');
Route::post('/host/hubert/payments/decline/{paymentId}', [HubertPaymentsController::class, 'HostHubertDeclinePayment'])->name('host.huberts.payments.decline');

// EXPENSES
Route::get('/host/huberts/expenses', [HubertExpensesController::class, 'HostHubertExpensesPage'])->name('host.huberts.expenses.page');
Route::post('/host/hubert/expenses/{id}/approve', [HubertExpensesController::class, 'HostHubertApprovedRequest'])->name('host.hubert.expenses.approve');
Route::delete('/host/hubert/expenses/{id}/decline', [HubertExpensesController::class, 'HostHubertDeclineRequest'])->name('host.hubert.expenses.decline');

// ANNOUNCEMENT MANAGEMENT
Route::get('/host/hubert/announcement-management', [HubertAnnouncementController::class, 'HostHubertAnnouncementPage'])->name('host.huberts.announcement.page');
Route::post('/host/hubert/announcements/{id}/approve', [HubertAnnouncementController::class, 'HostHubertAnnouncementApprove'])->name('host.hubert.announcements.approve');
Route::post('/host/hubert/announcements/{id}/decline', [HubertAnnouncementController::class, 'HostHubertAnnouncementDecline'])->name('host.hubert.announcements.decline');
Route::post('/host/hubert/announcements/{id}/delete', [HubertAnnouncementController::class, 'HostHubertAnnouncementDelete'])->name('host.hubert.announcements.delete');

// REQUEST MANAGENENT
Route::get('/host/hubert/request-management', [HostHubertRequestController::class, 'HostHubertRequestPage'])->name('host.huberts.request.page');
Route::patch('/host/hubert/request/{id}/address', [HostHubertRequestController::class, 'HostHubertRequestAddressRequest'])
    ->name('host.hubert.request.address');
Route::delete('/host/hubert/request/{id}/delete', [HostHubertRequestController::class, 'HostHubertRequestAddressRequest'])
    ->name('host.hubert.request.delete');

// PAYMENT PROOF
Route::get('/host/hubert/payment_proof', [HostHubertPaymentProofController::class, 'HostHubertPaymentProofPage'])->name('host.hubert.paymemt.proof.page');

// BALANCES PAID DELIQUENT
Route::get('/host/hubert/balance', [BalanceController::class, 'HostHubertBalancePage'])->name('host.hubert.balance.page');
Route::get('/host/hubert/balance/paid', [BalanceController::class, 'HostHubertBalancePaidPage'])->name('host.hubert.balance.paid.page');
Route::get('/host/hubert/balance/delinquent', [BalanceController::class, 'HostHubertBalanceDelinquentPage'])->name('host.hubert.balance.delinquent.page');


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
Route::get('/admin/hubert/print/summary', [UnitsController::class, 'printSummary'])->name('admin.hubert.print.summary');
Route::get('/admin/hubert/print/billings', [UnitsController::class, 'printBillings'])->name('admin.hubert.print.billings');
Route::get('/admin/hubert/print/payments', [UnitsController::class, 'printPayments'])->name('admin.hubert.print.payments');

Route::post('/admin/huberts/unit/follou-up-billings', [UnitsController::class, 'AdminHubertFollowUpBillings'])->name('admin.units.follow.up.billings');

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

// HUBERTS REQUEST TO MANAGER PAGE
Route::get('/admin/hubert/request_to_manager', [RequestToManagerController::class, 'AdminHubertRequestToManagerPage'])->name('admin.hubert.request_to_manager.page');
Route::post('/admin/hubert/request_to_manager/request', [RequestToManagerController::class, 'AdminHubertRequestToManagerRequest'])->name('admin.hubert.request_to_manager.request');

// HUBERTS PROOF OF PAYMENT PAGE
Route::get('/admin/hubert/payment_proof', [HubertPaymentProofController::class, 'AdminHubertPaymentProofPage'])->name('admin.hubert.paymemt.proof.page');

// HUBERTS BALANCE
Route::get('/admin/hubert/balance', [HubertBalanceController::class, 'AdminHubertBalancePage'])->name('admin.hubert.balance.page');
Route::get('/admin/hubert/balance/paid', [HubertBalanceController::class, 'AdminHubertBalancePaidPage'])->name('admin.hubert.balance.paid.page');
Route::get('/admin/hubert/balance/delinquent', [HubertBalanceController::class, 'AdminHubertBalanceDelinquentPage'])->name('admin.hubert.balance.delinquent.page');

// HUBERTS NOTIFICATIONS
Route::get('/admin/hubert/notification/view/{id}', [NotificationController::class, 'TenantsHubertMarkViewedNotifications'])->name('admin.hubert.notification.view');
Route::delete('/admin/hubert/notification/delete/{id}', [NotificationController::class, 'TenantsHubertDeleteNotification'])->name('admin.hubert.notification.delete');


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

Route::get('/tenants/reset-password/{forgot_code}', [TenantAuthController::class, 'showResetPasswordForm'])->name('tenants.reset.form');

// Handle Forgot Password Form Submission
Route::post('/tenants/forgot-password-request', [TenantAuthController::class, 'TenantsForgotPasswordRequest'])->name('tenants.forgot.password.request');

// Handle Reset Password Submission
Route::post('/tenants/reset-password', [TenantAuthController::class, 'resetPassword'])->name('tenants.reset.password');


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
// TENANTS HUBERTS PAYMENTS PROOF
Route::post('/tenant/huberts/payment-proof', [PaymentProofController::class, 'TenantsHubertMyPaymentRequest'])->name('tenant.huberts.payment.proof.request');



// JJS1
Route::get('/tenants/jjs1/dashboard', [TenantJjs1DashboardController::class, 'TenantsJjs1DashboardPage'])->name('tenants.jjs1.dashboard.page');
// JJS2
Route::get('/tenants/jjs2/dashboard', [TenantJjs2DashboardController::class, 'TenantsJjs2DashboardPage'])->name('tenants.jjs2.dashboard.page');
