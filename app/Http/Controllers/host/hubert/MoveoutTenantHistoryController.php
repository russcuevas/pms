<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MoveoutTenantHistoryController extends Controller
{
    public function HubertTenantHistoryPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        return view('host.hubert.history');
    }

    public function HubertTenantBillingHistoryPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $historyData = DB::table('history_billings')
            ->select(
                DB::raw('MAX(id) as id'),
                DB::raw('MAX(unit_id) as unit_id'),
                'tenant_code',
                DB::raw('MAX(property_id) as property_id'),
                DB::raw('MAX(tenant_name) as tenant_name'),
                DB::raw('MAX(tenant_phone_number) as tenant_phone_number'),
                DB::raw('MAX(tenant_email) as tenant_email'),
                DB::raw('MAX(account_number) as account_number'),
                DB::raw('MAX(soa_no) as soa_no'),
                DB::raw('MAX(for_the_month_of) as for_the_month_of'),
                DB::raw('MAX(statement_date) as statement_date'),
                DB::raw('MAX(due_date) as due_date'),
                DB::raw('MAX(rental) as rental'),
                DB::raw('MAX(water) as water'),
                DB::raw('MAX(electricity) as electricity'),
                DB::raw('MAX(parking) as parking'),
                DB::raw('MAX(foam) as foam'),
                DB::raw('MAX(previous_balance) as previous_balance'),
                DB::raw('MAX(amount) as amount'),
                DB::raw('MAX(total_balance_to_pay) as total_balance_to_pay'),
                DB::raw('MAX(total_payment) as total_payment'),
                DB::raw('MAX(current_electricity) as current_electricity'),
                DB::raw('MAX(previous_electricity) as previous_electricity'),
                DB::raw('MAX(consumption_electricity) as consumption_electricity'),
                DB::raw('MAX(rate_per_kwh_electricity) as rate_per_kwh_electricity'),
                DB::raw('MAX(total_electricity) as total_electricity'),
                DB::raw('MAX(current_water) as current_water'),
                DB::raw('MAX(previous_water) as previous_water'),
                DB::raw('MAX(consumption_water) as consumption_water'),
                DB::raw('MAX(rate_per_cu_water) as rate_per_cu_water'),
                DB::raw('MAX(total_water) as total_water'),
                DB::raw('MAX(status) as status'),
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('MAX(updated_at) as updated_at')
            )
            ->where('property_id', 1) // Filter where property_id = 1
            ->groupBy('tenant_code')
            ->get();

        return view('host.hubert.tenants_billings_history', compact('historyData'));
    }

    public function HubertTenantPaymentHistoryPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $paymentData = DB::table('history_payments')
            ->select(
                DB::raw('MAX(id) as id'),
                DB::raw('MAX(unit_id) as unit_id'),
                'tenant_code',
                DB::raw('MAX(property_id) as property_id'),
                DB::raw('MAX(tenant_name) as tenant_name'),
                DB::raw('MAX(tenant_phone_number) as tenant_phone_number'),
                DB::raw('MAX(tenant_email) as tenant_email'),
                DB::raw('MAX(amount) as amount'),
                DB::raw('MAX(for_the_month_of) as for_the_month_of'),
                DB::raw('MAX(reference_number) as reference_number'),
                DB::raw('MAX(mode_of_payment) as mode_of_payment'),
                DB::raw('MAX(type) as type'),
                DB::raw('MAX(is_approved) as is_approved'),
                DB::raw('MAX(created_at) as created_at'),
                DB::raw('MAX(updated_at) as updated_at')
            )
            ->where('property_id', 1) // Filter by property ID
            ->groupBy('tenant_code')
            ->get();

        return view('host.hubert.tenants_payments_history', compact('paymentData'));
    }

    public function HubertViewTenantPaymentHistory($tenant_code)
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $history_payments = DB::table('history_payments')
            ->leftJoin('units', 'history_payments.unit_id', '=', 'units.id')
            ->where('tenant_code', $tenant_code)
            ->select(
                'history_payments.*',
                'units.units_name'
            )
            ->get();

        // Pass the data to the view
        return view('host.hubert.tenants_payments_details', compact('history_payments', 'tenant_code'));
    }


public function HubertViewTenantBillingHistory($tenant_code)
{
    if (!Auth::guard('hosts')->check()) {
        return redirect()->route('host.login.page')->with('error', 'Please log in.');
    }

    // Fetch all records with the same tenant_code and join with the units table to get units_name
    $history_billings = DB::table('history_billings')
        ->leftJoin('units', 'history_billings.unit_id', '=', 'units.id') // LEFT JOIN on unit_id (from history_billings) and id (from units)
        ->where('tenant_code', $tenant_code)
        ->select(
            'history_billings.*', // Select all columns from history_billings
            'units.units_name' // Select units_name from the units table
        )
        ->get();

    // Pass the data to the view
    return view('host.hubert.tenant_details', compact('history_billings', 'tenant_code'));
}


}


