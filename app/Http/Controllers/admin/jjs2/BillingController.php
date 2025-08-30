<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BillingController extends Controller
{
    public function AdminJjs2BillingPage(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $unit_id = $request->unit_id;
        $tenant_id = $request->tenant_id;
        $property_id = $admin->property_id;

        $tenant = DB::table('tenants')->where('id', $tenant_id)->first();
        $unit = DB::table('units')->where('id', $unit_id)->first();

        $lastBilling = DB::table('billings')
            ->where('tenant_id', $tenant_id)
            ->orderByDesc('created_at')
            ->first();

        // If $lastBilling exists, get total_balance_to_pay, else 0
        $lastTotalBalance = $lastBilling ? $lastBilling->total_balance_to_pay : 0;

        return view('admin.jjs2.billing', compact('tenant', 'unit', 'property_id', 'lastTotalBalance'));
    }



    public function AdminJjs2BillingCreate(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $request->validate([
            'account_number' => 'required|string|max:255',
            'soa_no' => 'required|string|max:255',
            'for_the_month_of' => 'required|date',
            'statement_date' => 'required|date',
            'due_date' => 'required|date',
            'rental' => 'required|numeric',
            'water' => 'nullable|numeric',
            'electricity' => 'nullable|numeric',
            'parking' => 'nullable|numeric',
            'foam' => 'nullable|numeric',
            'previous_balance' => 'nullable|numeric',
            'current_electricity' => 'nullable|numeric',
            'previous_electricity' => 'nullable|numeric',
            'consumption_electricity' => 'nullable|numeric',
            'rate_per_kwh_electricity' => 'nullable|numeric',
            'total_electricity' => 'nullable|numeric',
            'current_water' => 'nullable|numeric',
            'previous_water' => 'nullable|numeric',
            'consumption_water' => 'nullable|numeric',
            'rate_per_cu_water' => 'nullable|numeric',
            'total_water' => 'nullable|numeric',
        ]);

        $totalBalance =
            ($request->rental ?? 0) +
            ($request->water ?? 0) +
            ($request->electricity ?? 0) +
            ($request->parking ?? 0) +
            ($request->foam ?? 0) +
            ($request->previous_balance ?? 0);

        // Insert into billings and get ID
        $billingId = DB::table('billings')->insertGetId([
            'unit_id' => $request->unit_id,
            'property_id' => $request->property_id,
            'tenant_id' => $request->tenant_id,
            'account_number' => $request->account_number,
            'soa_no' => $request->soa_no,
            'for_the_month_of' => $request->for_the_month_of,
            'statement_date' => $request->statement_date,
            'due_date' => $request->due_date,
            'rental' => $request->rental,
            'water' => $request->water,
            'electricity' => $request->electricity,
            'parking' => $request->parking,
            'foam' => $request->foam,
            'previous_balance' => $request->previous_balance,
            'total_balance_to_pay' => $totalBalance,
            'total_payment' => $totalBalance,
            'current_electricity' => $request->current_electricity,
            'previous_electricity' => $request->previous_electricity,
            'consumption_electricity' => $request->consumption_electricity,
            'rate_per_kwh_electricity' => $request->rate_per_kwh_electricity,
            'total_electricity' => $request->total_electricity,
            'current_water' => $request->current_water,
            'previous_water' => $request->previous_water,
            'consumption_water' => $request->consumption_water,
            'rate_per_cu_water' => $request->rate_per_cu_water,
            'total_water' => $request->total_water,
            'status' => 'delinquent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $billing = DB::table('billings')
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->select('billings.*', 'tenants.email', 'tenants.fullname', 'units.units_name')
            ->where('billings.id', $billingId)
            ->first();

        if ($billing && $billing->email) {
            $html = view('admin.jjs2.emails.billing_invoice', ['billing' => $billing])->render();

            Mail::send([], [], function ($message) use ($billing, $html) {
                $message->to($billing->email)
                    ->subject('Your Billing Statement - ' . date('F Y', strtotime($billing->for_the_month_of)))
                    ->from('gmanagementtt111@gmail.com', 'AVA Properties')
                    ->html($html);
            });
        }

        DB::table('tenant_notifications')->insert([
            'tenant_id' => $request->tenant_id,
            'property_id' => $request->property_id,
            'type' => 'billing',
            'title' => 'Billing',
            'message' => 'Your new billing for ' . $request->for_the_month_of . ' has been added.',
            'url' => '/tenants/jjs2/my-billing',
            'extra' => json_encode([
                'amount' => $totalBalance,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.jjs2.units.management.page')
            ->with('success', 'Billing created and display record saved successfully.');
    }
}
