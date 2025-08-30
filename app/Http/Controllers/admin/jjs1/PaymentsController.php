<?php

namespace App\Http\Controllers\admin\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{
    public function AdminJjs1PaymentPage(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 2) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $unit_id = $request->query('unit_id');
        $tenant_id = $request->query('tenant_id');

        $unit = DB::table('units')->find($unit_id);
        $tenant = DB::table('tenants')->find($tenant_id);

        $billing = DB::table('billings')
            ->where('tenant_id', $tenant_id)
            ->orderByDesc('created_at')
            ->first();

        if (!$billing) {
            return back()->with('error', 'No pending balance to pay.');
        }

        if ((float) $billing->total_balance_to_pay <= 0) {
            return back()->with('error', 'All balance for this tenants and unit are paid.');
        }

        return view('admin.jjs1.payments', compact('unit', 'tenant', 'billing'));
    }


    public function AdminJjs1PaymentRequest(Request $request)
{
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 2) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

    $request->validate([
        'unit_id' => 'required|exists:units,id',
        'tenant_id' => 'required|exists:tenants,id',
        'property_id' => 'required|exists:properties,id',
        'billings_id' => 'required|exists:billings,id',
        'amount' => 'required|numeric|min:0.01',
        'for_the_month_of' => 'required|string',
        'reference_number' => 'required|string|max:255',
        'mode_of_payment' => 'required|string|max:255',
        'type' => 'required|string',
    ]);

    $billing = DB::table('billings')->where('id', $request->billings_id)->first();
    if (!$billing) {
        return back()->withErrors(['amount' => 'Billing record not found.'])->withInput();
    }

    if ($request->amount > $billing->total_balance_to_pay) {
        return back()->withErrors(['amount' => 'The amount cannot be more than the total balance to pay (₱' . number_format($billing->total_balance_to_pay, 2) . ').'])->withInput();
    }

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
        $newAmount = $billing->amount + $request->amount;
        $newBalance = max(0, $billing->total_balance_to_pay - $request->amount);
        $status = $newBalance == 0 ? 'paid' : 'delinquent';

        // Update the billing record
        DB::table('billings')->where('id', $billing->id)->update([
            'amount' => $newAmount,
            'total_balance_to_pay' => $newBalance,
            'status' => $status,
            'updated_at' => now(),
        ]);

        $cashOnHand = DB::table('cash_on_hands')->where('property_id', $billing->property_id)->first();

        if ($cashOnHand) {
            DB::table('cash_on_hands')->where('id', $cashOnHand->id)->update([
                'total_cash_amount' => $cashOnHand->total_cash_amount + $request->amount,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('cash_on_hands')->insert([
                'property_id' => $billing->property_id,
                'total_cash_amount' => $request->amount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('monthly_sales')->insert([
            'unit_id' => $request->unit_id,
            'property_id' => $request->property_id,
            'amount' => $request->amount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $payment = DB::table('payments')
    ->join('tenants', 'payments.tenant_id', '=', 'tenants.id')
    ->join('units', 'payments.unit_id', '=', 'units.id')
    ->select('payments.*', 'tenants.email', 'tenants.fullname', 'units.units_name')
    ->where('payments.reference_number', $request->reference_number)
    ->first();

    if ($payment && $payment->email) {
        $html = view('admin.jjs1.emails.payment_invoice', ['payment' => $payment])->render();

        Mail::send([], [], function ($message) use ($payment, $html) {
            $message->to($payment->email)
                ->subject('Your Payment ' . ($payment->mode_of_payment === 'cash' ? 'Receipt' : 'Request') . ' - ' . date('F Y'))
                ->from('gmanagementtt111@gmail.com', 'AVA Properties')
                ->html($html);
        });
    }


    // Insert notification for the tenant
    DB::table('tenant_notifications')->insert([
        'tenant_id' => $request->tenant_id,
        'property_id' => $request->property_id,
        'type' => 'payment',
        'title' => 'Payment ' . ($request->mode_of_payment == 'cash' ? 'Received' : 'Requested'),
        'message' => 'A payment has been ' . ($request->mode_of_payment == 'cash' ? 'received' : 'requested') . ' for ' . $request->for_the_month_of . '.',
        'url' => '/tenants/jjs1/my-payment',
        'extra' => json_encode([
            'reference_number' => $request->reference_number,
            'mode_of_payment' => $request->mode_of_payment,
            'total_amount_requested' => '₱' . number_format($request->amount, 2),
            'type' => $request->type,
        ]),
        // 'is_view' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);



    $message = $request->mode_of_payment === 'cash'
        ? 'Payment recorded successfully.'
        : 'Online payment submitted. Please wait for the approval of the host.';

    return redirect()->route('admin.jjs1.units.management.page')
        ->with('success', $message);
}
}
