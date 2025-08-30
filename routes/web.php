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
use App\Http\Controllers\admin\jjs1\AnnouncementController as AdminJjs1AnnouncementController;
use App\Http\Controllers\admin\jjs1\BalanceController as AdminJjs1BalanceController;
use App\Http\Controllers\admin\jjs1\BillingController as AdminJjs1BillingController;
use App\Http\Controllers\admin\jjs1\DashboardController as AdminJjs1DashboardController;
use App\Http\Controllers\admin\jjs1\ExpensesController as Jjs1ExpensesController;
use App\Http\Controllers\admin\jjs1\PaymentProofController as AdminJjs1PaymentProofController;
use App\Http\Controllers\admin\jjs1\PaymentsController as AdminJjs1PaymentsController;
use App\Http\Controllers\admin\jjs1\RequestController as AdminJjs1RequestController;
use App\Http\Controllers\admin\jjs1\RequestToManagerController as AdminJjs1RequestToManagerController;
use App\Http\Controllers\admin\jjs1\UnitsController as Jjs1UnitsController;
use App\Http\Controllers\admin\jjs2\DashboardController as AdminJjs2DashboardController;
use App\Http\Controllers\host\hubert\AnnouncementController as HubertAnnouncementController;
use App\Http\Controllers\host\hubert\BalanceController;
use App\Http\Controllers\host\hubert\MonthlySalesController;
use App\Http\Controllers\host\hubert\PaymentProofController as HostHubertPaymentProofController;
use App\Http\Controllers\host\hubert\RequestToManagerController as HubertRequestToManagerController;
use App\Http\Controllers\host\jjs1\AdminController as Jjs1AdminController;
use App\Http\Controllers\host\jjs1\AnnouncementController as Jjs1AnnouncementController;
use App\Http\Controllers\host\jjs1\BalanceController as Jjs1BalanceController;
use App\Http\Controllers\host\jjs1\BillingController as Jjs1BillingController;
use App\Http\Controllers\host\jjs1\ExpenseController;
use App\Http\Controllers\host\jjs1\MonthlySalesController as Jjs1MonthlySalesController;
use App\Http\Controllers\host\jjs1\PaymentProofController as Jjs1PaymentProofController;
use App\Http\Controllers\host\jjs1\PaymentsController as Jjs1PaymentsController;
use App\Http\Controllers\host\jjs1\RequestController as Jjs1RequestController;
use App\Http\Controllers\host\jjs1\RequestToManagerController as Jjs1RequestToManagerController;
use App\Http\Controllers\host\jjs1\TurnOverController as Jjs1TurnOverController;
use App\Http\Controllers\host\jjs2\AdminController as Jjs2AdminController;
use App\Http\Controllers\host\jjs2\AnnouncementController as Jjs2AnnouncementController;
use App\Http\Controllers\host\jjs2\BillingController as Jjs2BillingController;
use App\Http\Controllers\host\jjs2\ExpenseController as Jjs2ExpenseController;
use App\Http\Controllers\host\jjs2\MonthlySalesController as Jjs2MonthlySalesController;
use App\Http\Controllers\host\jjs2\PaymentProofController as Jjs2PaymentProofController;
use App\Http\Controllers\host\jjs2\PaymentsController as Jjs2PaymentsController;
use App\Http\Controllers\host\jjs2\RequestController as Jjs2RequestController;
use App\Http\Controllers\host\jjs2\RequestToManagerController as Jjs2RequestToManagerController;
use App\Http\Controllers\host\jjs2\TurnOverController as Jjs2TurnOverController;
use App\Http\Controllers\tenant\hubert\AnnouncementController as TenantHubertAnnouncementController;
// TENANTS
use App\Http\Controllers\tenant\hubert\DashboardController as TenantHubertDashboardController;
use App\Http\Controllers\tenant\hubert\NotificationController;
use App\Http\Controllers\tenant\hubert\PaymentController;
use App\Http\Controllers\tenant\hubert\PaymentProofController;
use App\Http\Controllers\tenant\hubert\RequestController;
use App\Http\Controllers\tenant\hubert\ViewBillingController;
use App\Http\Controllers\tenant\jjs1\AnnouncementController as TenantJjs1AnnouncementController;
use App\Http\Controllers\tenant\jjs1\DashboardController as TenantJjs1DashboardController;
use App\Http\Controllers\tenant\jjs1\PaymentController as Jjs1PaymentController;
use App\Http\Controllers\tenant\jjs1\PaymentProofController as TenantJjs1PaymentProofController;
use App\Http\Controllers\tenant\jjs1\RequestController as TenantJjs1RequestController;
use App\Http\Controllers\tenant\jjs1\ViewBillingController as Jjs1ViewBillingController;
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
Route::get('/host/huberts/monthly-sales', [MonthlySalesController::class, 'HostHubertMonthlySalesComputation'])->name('host.huberts.monthly.sales');
Route::get('/host/huberts/monthly-expenses', [MonthlySalesController::class, 'HostHubertMonthlyExpensesComputation'])->name('host.huberts.monthly.expenses');
Route::get('/host/huberts/monthly-net-income', [MonthlySalesController::class, 'HostHubertMonthlyNetIncomeComputation'])->name('host.huberts.monthly.net.income');
Route::get('/host/hubert/payment-breakdown', [MonthlySalesController::class, 'HostHubertPaymentBreakdown']);


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
Route::get('/host/hubert/print/expenses', [HubertExpensesController::class, 'HostHubertExpensesPrintPage'])
    ->name('host.hubert.print.expenses');

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


// START JJS1
// JJS1
Route::get('/host/jjs1/dashboard', [Jjs1DashboardController::class, 'HostJjs1DashboardPage'])->name('host.jjs1.dashboard.page');
Route::get('/host/jjs1/monthly-sales', [Jjs1MonthlySalesController::class, 'HostJjs1MonthlySalesComputation'])->name('host.jjs1.monthly.sales');
Route::get('/host/jjs1/monthly-expenses', [Jjs1MonthlySalesController::class, 'HostJjs1MonthlyExpensesComputation'])->name('host.jjs1.monthly.expenses');
Route::get('/host/jjs1/monthly-net-income', [Jjs1MonthlySalesController::class, 'HostJjs1MonthlyNetIncomeComputation'])->name('host.jjs1.monthly.net.income');
Route::get('/host/jjs1/payment-breakdown', [Jjs1MonthlySalesController::class, 'HostJjs1PaymentBreakdown']);


// ADMIN MANAGEMENT
Route::get('/host/jjs1/admin-management', [Jjs1AdminController::class, 'HostJjs1AdminPage'])->name('host.jjs1.admin.management.page');
Route::patch('/host/jjs1/admin-management/update-approval/{id}', [Jjs1AdminController::class, 'HostJjs1UpdateApproval'])->name('host.jjs1.update.admin.approval');

// TURNOVERS
Route::get('/host/jjs1/turnovers', [Jjs1TurnOverController::class, 'Jjs1TurnOverPage'])->name('host.jjs1.turnover.page');
Route::post('host/jjs1/turnovers/{id}/approve', [Jjs1TurnOverController::class, 'Jjs1TurnOverApproveRequest'])->name('host.jjs1.turnovers.approve');
Route::delete('host/jjs1/turnovers/{id}/decline', [Jjs1TurnOverController::class, 'Jjs1TurnOverDeclineRequest'])->name('host.jjs1.turnovers.decline');


// ADMIN REQUEST
Route::get('/host/jjs1/admin-request', [Jjs1RequestToManagerController::class, 'HostJjs1RequestToManagerPage'])->name('host.jjs1.request_to_manager.page');
Route::patch('/host/jjs1/request-to-manager/{id}/approve', [Jjs1RequestToManagerController::class, 'HostJjs1RequestToManagerApprove'])
    ->name('host.jjs1.request_to_manager.approve');
Route::delete('/host/jjs1/request-to-manager/{id}/decline', [Jjs1RequestToManagerController::class, 'HostJjs1RequestToManagerDecline'])
    ->name('host.jjs1.request_to_manager.decline');
Route::delete('/host/jjs1/request-to-manager/{id}/delete', [Jjs1RequestToManagerController::class, 'HostJjs1RequestToManagerDelete'])
    ->name('host.jjs1.request_to_manager.delete');


// BILLING MANAGEMENT
Route::get('/host/jjs1/previous-billings/{tenantId}', [Jjs1BillingController::class, 'HostJjs1ViewPreviousBillings'])->name('host.jjs1.previous.billings');
Route::get('/host/jjs1/billing', [Jjs1BillingController::class, 'HostJjs1BillingPage'])->name('host.jjs1.billing.page');


// PAYMENTS MANAGEMENT
Route::get('/host/jjs1/payments', [Jjs1PaymentsController::class, 'HostJjs1PaymentsPage'])->name('host.jjs1.payments.page');
Route::post('/host/jjs1/payments/approve/{paymentId}', [Jjs1PaymentsController::class, 'HostJjs1ApprovePayment'])->name('host.jjs1.payments.approve');
Route::post('/host/jjs1/payments/decline/{paymentId}', [Jjs1PaymentsController::class, 'HostJjs1DeclinePayment'])->name('host.jjs1.payments.decline');

// EXPENSES
Route::get('/host/jjs1/expenses', [ExpenseController::class, 'HostJjs1ExpensesPage'])->name('host.jjs1.expenses.page');
Route::post('/host/jjs1/expenses/{id}/approve', [ExpenseController::class, 'HostJjs1ApprovedRequest'])->name('host.jjs1.expenses.approve');
Route::delete('/host/jjs1/expenses/{id}/decline', [ExpenseController::class, 'HostJjs1DeclineRequest'])->name('host.jjs1.expenses.decline');
Route::get('/host/jjs1/print/expenses', [ExpenseController::class, 'HostJjs1ExpensesPrintPage'])
    ->name('host.jjs1.print.expenses');

// ANNOUNCEMENT MANAGEMENT
Route::get('/host/jjs1/announcement-management', [Jjs1AnnouncementController::class, 'HostJjs1AnnouncementPage'])->name('host.jjs1.announcement.page');
Route::post('/host/jjs1/announcements/{id}/approve', [Jjs1AnnouncementController::class, 'HostJjs1AnnouncementApprove'])->name('host.jjs1.announcements.approve');
Route::post('/host/jjs1/announcements/{id}/decline', [Jjs1AnnouncementController::class, 'HostJjs1AnnouncementDecline'])->name('host.jjs1.announcements.decline');
Route::post('/host/jjs1/announcements/{id}/delete', [Jjs1AnnouncementController::class, 'HostJjs1AnnouncementDelete'])->name('host.jjs1.announcements.delete');

// REQUEST MANAGENENT
Route::get('/host/jjs1/request-management', [Jjs1RequestController::class, 'HostJjs1RequestPage'])->name('host.jjs1.request.page');
Route::patch('/host/jjs1/request/{id}/address', [Jjs1RequestController::class, 'HostJjs1RequestAddressRequest'])
    ->name('host.jjs1.request.address');
Route::delete('/host/jjs1/request/{id}/delete', [Jjs1RequestController::class, 'HostJjs1RequestAddressRequest'])
    ->name('host.jjs1.request.delete');

// PAYMENT PROOF
Route::get('/host/jjs1/payment_proof', [Jjs1PaymentProofController::class, 'HostJjs1PaymentProofPage'])->name('host.jjs1.paymemt.proof.page');

// BALANCES PAID DELIQUENT
Route::get('/host/jjs1/balance', [Jjs1BalanceController::class, 'HostJjs1BalancePage'])->name('host.jjs1.balance.page');
Route::get('/host/jjs1/balance/paid', [Jjs1BalanceController::class, 'HostJjs1BalancePaidPage'])->name('host.jjs1.balance.paid.page');
Route::get('/host/jjs1/balance/delinquent', [Jjs1BalanceController::class, 'HostJjs1BalanceDelinquentPage'])->name('host.jjs1.balance.delinquent.page');
// END JJS1








// JJS2
Route::get('/host/jjs2/dashboard', [Jjs2DashboardController::class, 'HostJjs2DashboardPage'])->name('host.jjs2.dashboard.page');
Route::get('/host/jjs2/monthly-sales', [Jjs2MonthlySalesController::class, 'HostJjs2MonthlySalesComputation'])->name('host.jjs2.monthly.sales');
Route::get('/host/jjs2/monthly-expenses', [Jjs2MonthlySalesController::class, 'HostJjs2MonthlyExpensesComputation'])->name('host.jjs2.monthly.expenses');
Route::get('/host/jjs2/monthly-net-income', [Jjs2MonthlySalesController::class, 'HostJjs2MonthlyNetIncomeComputation'])->name('host.jjs2.monthly.net.income');
Route::get('/host/jjs2/payment-breakdown', [Jjs2MonthlySalesController::class, 'HostJjs2PaymentBreakdown']);



// ADMIN MANAGEMENT
Route::get('/host/jjs2/admin-management', [Jjs2AdminController::class, 'HostJjs2AdminPage'])->name('host.jjs2.admin.management.page');
Route::patch('/host/jjs2/admin-management/update-approval/{id}', [Jjs2AdminController::class, 'HostJjs2UpdateApproval'])->name('host.jjs2.update.admin.approval');

// TURNOVERS
Route::get('/host/jjs2/turnovers', [Jjs2TurnOverController::class, 'Jjs2TurnOverPage'])->name('host.jjs2.turnover.page');
Route::post('/host/jjs2/turnovers/{id}/approve', [Jjs2TurnOverController::class, 'Jjs2TurnOverApproveRequest'])->name('host.jjs2.turnovers.approve');
Route::delete('/host/jjs2/turnovers/{id}/decline', [Jjs2TurnOverController::class, 'Jjs2TurnOverDeclineRequest'])->name('host.jjs2.turnovers.decline');

// ADMIN REQUEST
Route::get('/host/jjs2/admin-request', [Jjs2RequestToManagerController::class, 'HostJjs2RequestToManagerPage'])->name('host.jjs2.request_to_manager.page');
Route::patch('/host/jjs2/request-to-manager/{id}/approve', [Jjs2RequestToManagerController::class, 'HostJjs2RequestToManagerApprove'])
    ->name('host.jjs2.request_to_manager.approve');
Route::delete('/host/jjs2/request-to-manager/{id}/decline', [Jjs2RequestToManagerController::class, 'HostJjs2RequestToManagerDecline'])
    ->name('host.jjs2.request_to_manager.decline');
Route::delete('/host/jjs2/request-to-manager/{id}/delete', [Jjs2RequestToManagerController::class, 'HostJjs2RequestToManagerDelete'])
    ->name('host.jjs2.request_to_manager.delete');


    
// BILLING MANAGEMENT
Route::get('/host/jjs2/previous-billings/{tenantId}', [Jjs2BillingController::class, 'HostJjs2ViewPreviousBillings'])->name('host.jjs2.previous.billings');
Route::get('/host/jjs2/billing', [Jjs2BillingController::class, 'HostJjs2BillingPage'])->name('host.jjs2.billing.page');



// PAYMENTS MANAGEMENT
Route::get('/host/jjs2/payments', [Jjs2PaymentsController::class, 'HostJjs2PaymentsPage'])->name('host.jjs2.payments.page');
Route::post('/host/jjs2/payments/approve/{paymentId}', [Jjs2PaymentsController::class, 'HostJjs2ApprovePayment'])->name('host.jjs2.payments.approve');
Route::post('/host/jjs2/payments/decline/{paymentId}', [Jjs2PaymentsController::class, 'HostJjs2DeclinePayment'])->name('host.jjs2.payments.decline');

// EXPENSES
Route::get('/host/jjs2/expenses', [Jjs2ExpenseController::class, 'HostJjs2ExpensesPage'])->name('host.jjs2.expenses.page');
Route::post('/host/jjs2/expenses/{id}/approve', [Jjs2ExpenseController::class, 'HostJjs2ApprovedRequest'])->name('host.jjs2.expenses.approve');
Route::delete('/host/jjs2/expenses/{id}/decline', [Jjs2ExpenseController::class, 'HostJjs2DeclineRequest'])->name('host.jjs2.expenses.decline');
Route::get('/host/jjs2/print/expenses', [Jjs2ExpenseController::class, 'HostJjs2ExpensesPrintPage'])
    ->name('host.jjs2.print.expenses');


// ANNOUNCEMENT MANAGEMENT
Route::get('/host/jjs2/announcement-management', [Jjs2AnnouncementController::class, 'HostJjs2AnnouncementPage'])->name('host.jjs2.announcement.page');
Route::post('/host/jjs2/announcements/{id}/approve', [Jjs2AnnouncementController::class, 'HostJjs2AnnouncementApprove'])->name('host.jjs2.announcements.approve');
Route::post('/host/jjs2/announcements/{id}/decline', [Jjs2AnnouncementController::class, 'HostJjs2AnnouncementDecline'])->name('host.jjs2.announcements.decline');
Route::post('/host/jjs2/announcements/{id}/delete', [Jjs2AnnouncementController::class, 'HostJjs2AnnouncementDelete'])->name('host.jjs2.announcements.delete');


// REQUEST MANAGENENT
Route::get('/host/jjs2/request-management', [Jjs2RequestController::class, 'HostJjs2RequestPage'])->name('host.jjs2.request.page');
Route::patch('/host/jjs2/request/{id}/address', [Jjs2RequestController::class, 'HostJjs2RequestAddressRequest'])
    ->name('host.jjs2.request.address');
Route::delete('/host/jjs2/request/{id}/delete', [Jjs2RequestController::class, 'HostJjs2RequestAddressRequest'])
    ->name('host.jjs2.request.delete');


// PAYMENT PROOF
Route::get('/host/jjs2/payment_proof', [Jjs2PaymentProofController::class, 'HostJjs2PaymentProofPage'])->name('host.jjs2.paymemt.proof.page');









































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
Route::get('/admin/hubert/print/expenses', [ExpensesController::class, 'AdminHubertExpensesPrintPage'])
    ->name('admin.hubert.print.expenses');


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





// ADMIN JJS1 START
// JJS1

// JJS1 DASHBOARD
Route::get('/admin/jjs1/dashboard', [AdminJjs1DashboardController::class, 'AdminJjs1DashboardPage'])->name('admin.jjs1.dashboard.page');
Route::post('/admin/jjs1/turn-over', [AdminJjs1DashboardController::class, 'AdminJjs1TurnOverMoney'])->name('admin.jjs1.turnover.request');
// END JJS1 DASHBOARD


// JJS1 EXPENSES
Route::get('/admin/jjs1/expenses', [Jjs1ExpensesController::class, 'AdminJjs1ExpensesPage'])->name('admin.jjs1.expenses.page');
Route::post('/admin/jjs1/expenses/create', [Jjs1ExpensesController::class, 'AdminJjs1ExpensesRequest'])->name('admin.jjs1.expenses.request');
Route::get('/admin/jjs1/print/expenses', [Jjs1ExpensesController::class, 'AdminJjs1ExpensesPrintPage'])
    ->name('admin.jjs1.print.expenses');

// JJS1 UNIT
Route::get('admin/jjs1/unit_management', [Jjs1UnitsController::class, 'AdminJjs1UnitsManagementPage'])->name('admin.jjs1.units.management.page');
Route::post('/admin/jjs1/units/transfer-and-repair', [Jjs1UnitsController::class, 'AdminJjs1TransferAndRepair'])->name('admin.units.transfer-and-repairjjs1');
Route::post('/admin/jjs1/units/mark-for-repair', [Jjs1UnitsController::class, 'AdminJjs1MarkForRepair'])->name('admin.units.mark-for-repairjjs1');
Route::post('/admin/jjs1/units/mark-as-repaired', [Jjs1UnitsController::class, 'AdminJjs1MarkAsRepaired'])->name('admin.units.mark-as-repairedjjs1');
Route::post('/admin/jjs1/unit/{unit}/moveout/{tenant}', [Jjs1UnitsController::class, 'AdminJjs1MoveOutTenant'])->name('admin.units.moveoutjjs1');
Route::get('/admin/jjs1/print/summary', [Jjs1UnitsController::class, 'Jjs1printSummary'])->name('admin.jjs1.print.summary');
Route::get('/admin/jjs1/print/billings', [Jjs1UnitsController::class, 'Jjs1printBillings'])->name('admin.jjs1.print.billings');
Route::get('/admin/jjs1/print/payments', [Jjs1UnitsController::class, 'Jjs1printPayments'])->name('admin.jjs1.print.payments');
Route::post('/admin/jjs1/unit/follou-up-billings', [Jjs1UnitsController::class, 'AdminJjs1FollowUpBillings'])->name('admin.jjs1.units.follow.up.billings');

// JJS1 BILLING PAGE
Route::get('/admin/jjs1/billing', [AdminJjs1BillingController::class, 'AdminJjs1BillingPage'])->name('admin.jjs1.billing.page');
Route::post('/admin/jjs1/billing/create', [AdminJjs1BillingController::class, 'AdminJjs1BillingCreate'])->name('admin.jjs1.billing.create');

// JJS1 PAYMENT PAGE
Route::get('/admin/jjs1/payments/create', [AdminJjs1PaymentsController::class, 'AdminJjs1PaymentPage'])->name('admin.jjs1.payments.page');
Route::post('/admin/jjs1/payments/store', [AdminJjs1PaymentsController::class, 'AdminJjs1PaymentRequest'])->name('admin.jjs1.payments.request');

// JJS1 PROOF OF PAYMENT PAGE
Route::get('/admin/jjs1/payment_proof', [AdminJjs1PaymentProofController::class, 'AdminJjs1PaymentProofPage'])->name('admin.jjs1.paymemt.proof.page');

// JJS1 REQUEST PAGE
Route::get('/admin/jjs1/request_management', [AdminJjs1RequestController::class, 'AdminJjs1RequestPage'])->name('admin.jjs1.request.page');
Route::put('/admin/jjs1/request/{id}/approve', [AdminJjs1RequestController::class, 'AdminJjs1tRequestApprove'])->name('admin.jjs1.request.approve');
Route::delete('/admin/jjs1/request/{id}/decline', [AdminJjs1RequestController::class, 'AdminJjs1RequestDecline'])->name('admin.jjs1.request.decline');


// JJS1 ANNOUNCEMENT PAGE
Route::get('/admin/jjs1/announcement_management', [AdminJjs1AnnouncementController::class, 'AdminJjs1AnnouncementPage'])->name('admin.jjs1.announcement.page');
Route::post('/admin/jjs1/announcement/request', [AdminJjs1AnnouncementController::class, 'AdminJjs1AnnouncementRequest'])->name('admin.jjs1.announcement.request');


// JJS1 REQUEST TO MANAGER PAGE
Route::get('/admin/jjs1/request_to_manager', [AdminJjs1RequestToManagerController::class, 'AdminJjs1RequestToManagerPage'])->name('admin.jjs1.request_to_manager.page');
Route::post('/admin/jjs1/request_to_manager/request', [AdminJjs1RequestToManagerController::class, 'AdminJjs1RequestToManagerRequest'])->name('admin.jjs1.request_to_manager.request');

// JJS1 BALANCE
Route::get('/admin/jjs1/balance', [AdminJjs1BalanceController::class, 'AdminJjs1BalancePage'])->name('admin.jjs1.balance.page');
Route::get('/admin/jjs1/balance/paid', [AdminJjs1BalanceController::class, 'AdminJjs1BalancePaidPage'])->name('admin.jjs1.balance.paid.page');
Route::get('/admin/jjs1/balance/delinquent', [AdminJjs1BalanceController::class, 'AdminJjs1BalanceDelinquentPage'])->name('admin.jjs1.balance.delinquent.page');

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

// HUBERTS NOTIFICATIONS
Route::get('/admin/hubert/notification/view/{id}', [NotificationController::class, 'TenantsHubertMarkViewedNotifications'])->name('admin.hubert.notification.view');
Route::delete('/admin/hubert/notification/delete/{id}', [NotificationController::class, 'TenantsHubertDeleteNotification'])->name('admin.hubert.notification.delete');



// JJS1
Route::get('/tenants/jjs1/dashboard', [TenantJjs1DashboardController::class, 'TenantsJjs1DashboardPage'])->name('tenants.jjs1.dashboard.page');
// TENANTS JJS1 BILLING PAGE
Route::get('/tenants/jjs1/my-billing', [Jjs1ViewBillingController::class, 'TenantsJjs1MyBillingPage'])->name('tenants.jjs1.my-billing.page');
// TENANTS JJS1 PAYMENT PAGE
Route::get('/tenants/jjs1/my-payment', [Jjs1PaymentController::class, 'TenantsJjs1MyPaymentPage'])->name('tenants.jjs1.my-payment.page');
// TENANTS JJS1 REQUEST PAGE
Route::get('/tenants/jjs1/my-request', [TenantJjs1RequestController::class, 'TenantsJjs1MyRequestPage'])->name('tenants.jjs1.my-request.page');
Route::post('/tenants/jjs1/my-request/post', [TenantJjs1RequestController::class, 'TenantsJjs1RequestPost'])->name('tenants.jjs1.my-request.post');
// TENANTS JJS1 ANNOUNCEMENT PAGE
Route::get('/tenants/jjs1/announcements', [TenantJjs1AnnouncementController::class, 'TenantsJjs1AnnouncementPage'])->name('tenants.jjs1.announcement.page');
// TENANTS JJS1 PAYMENTS PROOF
Route::post('/tenant/jjs1/payment-proof', [TenantJjs1PaymentProofController::class, 'TenantsJjs1MyPaymentRequest'])->name('tenant.jjs1.payment.proof.request');
// JJS1 NOTIFICATIONS
Route::get('/admin/jjs1/notification/view/{id}', [NotificationController::class, 'TenantsJjs1MarkViewedNotifications'])->name('admin.jjs1.notification.view');
Route::delete('/admin/jjs1/notification/delete/{id}', [NotificationController::class, 'TenantsJjs1DeleteNotification'])->name('admin.jjs1.notification.delete');





// JJS2
Route::get('/tenants/jjs2/dashboard', [TenantJjs2DashboardController::class, 'TenantsJjs2DashboardPage'])->name('tenants.jjs2.dashboard.page');
