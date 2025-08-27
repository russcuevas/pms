<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
     // Display all payments
    public function HostJjs1PaymentsPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $payments = DB::table('payments')
            ->join('tenants', 'payments.tenant_id', '=', 'tenants.id')
            ->join('units', 'payments.unit_id', '=', 'units.id')
            ->join('billings', 'payments.billings_id', '=', 'billings.id')
            ->where('tenants.property_id', 2)
            ->select(
                'payments.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name',
                'billings.soa_no'
            )
            ->orderByDesc('payments.created_at')
            ->get();

        return view('host.jjs1.payments', compact('payments'));
    }


    public function HostJjs1ApprovePayment($paymentId)
    {
        $payment = DB::table('payments')->find($paymentId);

        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }

        DB::table('payments')
            ->where('id', $paymentId)
            ->update(['is_approved' => 1]);

        $latestBilling = DB::table('billings')
            ->where('tenant_id', $payment->tenant_id)
            ->orderByDesc('created_at')
            ->first();

        if (!$latestBilling) {
            return back()->with('error', 'Billing record not found.');
        }

        $newAmount = $latestBilling->amount + $payment->amount;
        DB::table('billings')
            ->where('id', $latestBilling->id)
            ->update(['amount' => $newAmount]);

        $newBalance = $latestBilling->total_balance_to_pay - $payment->amount;
        DB::table('billings')
            ->where('id', $latestBilling->id)
            ->update(['total_balance_to_pay' => $newBalance]);

        if ($newBalance <= 0) {
            DB::table('billings')
                ->where('id', $latestBilling->id)
                ->update(['status' => 'paid']);
        }

        DB::table('monthly_sales')->insert([
            'unit_id' => $payment->unit_id,
            'property_id' => $payment->property_id,
            'amount' => $payment->amount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('host.jjs1.payments.page')->with('success', 'Payment approved, billing updated, and balance reduced.');
    }


    // Decline Payment
    public function HostJjs1DeclinePayment($paymentId)
    {
        $payment = DB::table('payments')->find($paymentId);

        if (!$payment) {
            return back()->with('error', 'Payment not found.');
        }

        DB::table('payments')
            ->where('id', $paymentId)
            ->delete();

        return redirect()->route('host.jjs1.payments.page')->with('success', 'Payment declined.');
    }
}
