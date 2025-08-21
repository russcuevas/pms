<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use App\Models\Billings;
use App\Models\HistoryBillings;
use App\Models\HistoryPayments;
use App\Models\Payments;
use App\Models\Tenants;
use App\Models\Units;
use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UnitsController extends Controller
{
    public function AdminUnitsManagementPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $units = DB::table('units')
            ->leftJoin('tenants', function ($join) {
                $join->on('units.id', '=', 'tenants.unit_id')
                    ->where('tenants.is_approved', true);
            })
            ->leftJoin(DB::raw('
            (
                SELECT tenant_id, total_balance_to_pay, status
                FROM billings
                WHERE id IN (
                    SELECT MAX(id)
                    FROM billings
                    GROUP BY tenant_id
                )
            ) as latest_billings
        '), 'tenants.id', '=', 'latest_billings.tenant_id')
            ->where('units.property_id', 1)
            ->select(
                'units.id as unit_id',
                'units.units_name',
                'units.status',
                'tenants.id as tenant_id',
                'tenants.fullname',
                'tenants.username',
                'tenants.email',
                'tenants.phone_number',
                'tenants.address',
                'tenants.move_in_date',
                'tenants.move_out_date',
                'tenants.created_at',
                'tenants.advance_deposit',
                'tenants.contact_fullname',
                'tenants.contact_phone_number',
                'latest_billings.total_balance_to_pay as current_balance',
                'latest_billings.status as billing_status'
            )
            ->get();

        $vacantUnits = DB::table('units')
            ->where('property_id', 1)
            ->where('status', 'vacant')
            ->select('id', 'units_name')
            ->get();

        return view('admin.hubert.units_management', compact('units', 'vacantUnits'));
    }


    public function AdminHubertTransferAndRepair(Request $request)
    {
        $request->validate([
            'current_unit_id' => 'required|integer|exists:units,id',
            'tenant_id' => 'required|integer|exists:tenants,id',
            'transfer_unit_id' => 'required|integer|exists:units,id',
        ]);

        DB::beginTransaction();

        try {
            // Update tenant to new unit
            DB::table('tenants')
                ->where('id', $request->tenant_id)
                ->update(['unit_id' => $request->transfer_unit_id]);

            // Mark old unit as for repair
            DB::table('units')
                ->where('id', $request->current_unit_id)
                ->update(['status' => 'for repair']);

            // Mark new unit as occupied
            DB::table('units')
                ->where('id', $request->transfer_unit_id)
                ->update(['status' => 'occupied']);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Tenant transferred and unit marked for repair successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to transfer tenant: ' . $e->getMessage()]);
        }
    }

    public function AdminHubertMarkForRepair(Request $request)
    {
        $request->validate(['unit_id' => 'required|integer|exists:units,id']);

        try {
            DB::table('units')
                ->where('id', $request->unit_id)
                ->update(['status' => 'for repair']);

            return response()->json(['success' => true, 'message' => 'Unit marked for repair']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function AdminHubertMarkAsRepaired(Request $request)
    {
        $request->validate(['unit_id' => 'required|integer|exists:units,id']);

        try {
            DB::table('units')
                ->where('id', $request->unit_id)
                ->update(['status' => 'vacant']);

            return response()->json(['success' => true, 'message' => 'Unit marked as repaired and now vacant']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status']);
        }
    }

public function AdminHubertMoveOutTenant($unitId, $tenantId)
{
    $historyBillingIds = [];
    $historyPaymentIds = [];

    DB::transaction(function () use ($unitId, $tenantId, &$historyBillingIds, &$historyPaymentIds) {
        $tenant = DB::table('tenants')->where('id', $tenantId)->first();
        $unit = DB::table('units')->where('id', $unitId)->first();

        if (!$tenant || !$unit) {
            abort(404, 'Tenant or Unit not found.');
        }

        // Get current billings
        $billings = DB::table('billings')->where('tenant_id', $tenantId)->get();
        $originalBillingIds = $billings->pluck('id');

        // Move billings to history
        foreach ($billings as $billing) {
            $historyBillingId = DB::table('history_billings')->insertGetId([
                'unit_id' => $billing->unit_id,
                'property_id' => $billing->property_id,
                'tenant_name' => $tenant->fullname,
                'tenant_phone_number' => $tenant->phone_number,
                'tenant_email' => $tenant->email,
                'account_number' => $billing->account_number,
                'soa_no' => $billing->soa_no,
                'for_the_month_of' => $billing->for_the_month_of,
                'statement_date' => $billing->statement_date,
                'due_date' => $billing->due_date,
                'rental' => $billing->rental,
                'water' => $billing->water,
                'electricity' => $billing->electricity,
                'parking' => $billing->parking,
                'foam' => $billing->foam,
                'previous_balance' => $billing->previous_balance,
                'amount' => $billing->amount,
                'total_balance_to_pay' => $billing->total_balance_to_pay,
                'total_payment' => $billing->total_payment,
                'current_electricity' => $billing->current_electricity,
                'previous_electricity' => $billing->previous_electricity,
                'consumption_electricity' => $billing->consumption_electricity,
                'rate_per_kwh_electricity' => $billing->rate_per_kwh_electricity,
                'total_electricity' => $billing->total_electricity,
                'current_water' => $billing->current_water,
                'previous_water' => $billing->previous_water,
                'consumption_water' => $billing->consumption_water,
                'rate_per_cu_water' => $billing->rate_per_cu_water,
                'total_water' => $billing->total_water,
                'status' => $billing->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $historyBillingIds[] = $historyBillingId;
        }

        // Get and move related payments
        $payments = DB::table('payments')
            ->whereIn('billings_id', $originalBillingIds)
            ->get();

        foreach ($payments as $payment) {
            $historyPaymentId = DB::table('history_payments')->insertGetId([
                'unit_id' => $payment->unit_id,
                'property_id' => $payment->property_id,
                'billings_id' => $payment->billings_id,
                'tenant_name' => $tenant->fullname,
                'tenant_phone_number' => $tenant->phone_number,
                'tenant_email' => $tenant->email,
                'amount' => $payment->amount,
                'for_the_month_of' => $payment->for_the_month_of,
                'reference_number' => $payment->reference_number,
                'mode_of_payment' => $payment->mode_of_payment,
                'type' => $payment->type,
                'is_approved' => $payment->is_approved,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $historyPaymentIds[] = $historyPaymentId;
        }

        // Clean up
        DB::table('payments')->whereIn('billings_id', $originalBillingIds)->delete();
        DB::table('billings')->where('tenant_id', $tenantId)->delete();
        DB::table('units')->where('id', $unitId)->update(['status' => 'vacant']);
        DB::table('tenants')->where('id', $tenantId)->delete();
    });

    // Store history IDs in session for PDF download
    Session::put('last_moved_billing_ids', $historyBillingIds);
    Session::put('last_moved_payment_ids', $historyPaymentIds);

    return redirect()->route('admin.hubert.print.summary')->with('success', 'Tenant moved out successfully. You can now print the summary.');
}

    public function printSummary()
    {
        return view('admin.hubert.print.print_summary');
    }

public function printBillings()
{
    $billingId = session('last_moved_billing_ids')[0] ?? null;

    $billing = DB::table('history_billings')
                ->leftJoin('units', 'history_billings.unit_id', '=', 'units.id')
                ->where('history_billings.id', $billingId)
                ->select('history_billings.*', 'units.id as unit_id', 'units.units_name')
                ->latest('history_billings.statement_date')
                ->first();

    if (!$billing) return back()->withErrors('No billing data found.');

    // Sanitize soa_no for filename
    $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $billing->soa_no) . '_SOA.pdf';

    $pdf = PDF::loadView('admin.hubert.print.print_billings', compact('billing'));
    return $pdf->download($fileName);
}


public function printPayments()
{
    $paymentId = session('last_moved_payment_ids')[0] ?? null;

    $payment = DB::table('history_payments')
                ->leftJoin('units', 'history_payments.unit_id', '=', 'units.id')
                ->where('history_payments.id', $paymentId)
                ->select('history_payments.*', 'units.units_name')
                ->latest('history_payments.created_at')
                ->first();

    if (!$payment) return back()->withErrors('No payment data found.');

    // Use the reference number in the file name, sanitize to avoid bad chars
    $fileName = preg_replace('/[^A-Za-z0-9_\-]/', '', $payment->reference_number) . '_payment_receipt.pdf';

    $pdf = PDF::loadView('admin.hubert.print.print_payments', compact('payment'));
    return $pdf->download($fileName);
}

    public function AdminHubertFollowUpBillings()
    {
        $latestBillings = DB::table('billings as b1')
            ->join(DB::raw('
                (
                    SELECT MAX(id) as latest_id
                    FROM billings
                    GROUP BY tenant_id
                ) as latest
            '), 'b1.id', '=', 'latest.latest_id')
            ->join('tenants', 'b1.tenant_id', '=', 'tenants.id')
            ->where('b1.property_id', 1)
            ->where('b1.total_balance_to_pay', '>', 0)
            ->select('tenants.fullname', 'tenants.email', 'b1.total_balance_to_pay', 'b1.for_the_month_of')
            ->get();

        $sentCount = 0;

        foreach ($latestBillings as $billing) {
            if (filter_var($billing->email, FILTER_VALIDATE_EMAIL)) {
                Mail::raw("Dear {$billing->fullname},

    This is a friendly reminder from Admin Huberts Residence that you have an outstanding balance of ₱" . number_format($billing->total_balance_to_pay, 2) . " for the billing month of {$billing->for_the_month_of}.

    Please make your payment as soon as possible.

    If you’ve already settled this amount, kindly ignore this message.

    Thank you,
    Admin Huberts Residence", function ($message) use ($billing) {
                    $message->to($billing->email)
                            ->subject('Follow Up: Outstanding Billing Notice');
                });

                $sentCount++;
            }
        }

        return back()->with('success', "Follow up billing email sent to tenants with unpaid balances.");
    }
}
