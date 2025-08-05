<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function AdminHubertPaymentPage(Request $request)
    {
        $unit_id = $request->query('unit_id');
        $tenant_id = $request->query('tenant_id');

        $unit = DB::table('units')->find($unit_id);
        $tenant = DB::table('tenants')->find($tenant_id);

        $billing = DB::table('billings')
            ->where('tenant_id', $tenant_id)
            ->orderByDesc('created_at')
            ->first();

        return view('admin.hubert.payments', compact('unit', 'tenant', 'billing'));
    }

    public function AdminHubertPaymentRequest(Request $request)
    {
        // Validate the request data
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'billings_id' => 'required|exists:billings,id',
            'amount' => 'required|numeric|min:0.01',
            'for_the_month_of' => 'required|string',
            'reference_number' => 'required|string|max:255',
            'mode_of_payment' => 'required|string|max:255',
            'type' => 'required|string|in:advance,deposit',
        ]);

        // Insert the payment record
        DB::table('payments')->insert([
            'unit_id' => $request->unit_id,
            'tenant_id' => $request->tenant_id,
            'property_id' => $request->property_id,
            'billings_id' => $request->billings_id,
            'amount' => $request->amount,
            'for_the_month_of' => $request->for_the_month_of,
            'reference_number' => $request->reference_number,
            'mode_of_payment' => $request->mode_of_payment,
            'type' => $request->type,
            'is_approved' => $request->mode_of_payment == 'cash' ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->mode_of_payment == 'cash') {
            $billing = DB::table('billings')->where('id', $request->billings_id)->first();

            if (!$billing) {
                return back()->with('error', 'Billing not found.');
            }

            // Compute new amount (add to existing)
            $newAmount = $billing->amount + $request->amount;

            // Compute new balance
            $newBalance = max(0, $billing->total_balance_to_pay - $request->amount);

            // Set status
            $status = $newBalance == 0 ? 'paid' : 'delinquent';

            // Update the billing record
            DB::table('billings')->where('id', $billing->id)->update([
                'amount' => $newAmount,
                'total_balance_to_pay' => $newBalance,
                'status' => $status,
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.huberts.units.management.page')
            ->with('success', 'Payment recorded successfully.' . ($request->mode_of_payment == 'cash' ? ' Billing updated automatically.' : ''));
    }
}
