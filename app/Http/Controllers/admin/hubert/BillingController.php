<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function AdminHubertBillingPage(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $unit_id = $request->unit_id;
        $tenant_id = $request->tenant_id;
        $property_id = $admin->property_id;

        $tenant = DB::table('tenants')->where('id', $tenant_id)->first();
        $unit = DB::table('units')->where('id', $unit_id)->first();

        return view('admin.hubert.billing', compact('tenant', 'unit', 'property_id'));
    }

    public function AdminHubertBillingCreate(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
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
            // Optional fields can be nullable + numeric
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

        DB::table('billings')->insert([
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
            'total_balance_to_pay' => (
                ($request->rental ?? 0) + ($request->water ?? 0) + ($request->electricity ?? 0) +
                ($request->parking ?? 0) + ($request->foam ?? 0) + ($request->previous_balance ?? 0)
            ),
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
            'status' => 'unpaid',
            'is_approved' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.huberts.units.management.page')
            ->with('success', 'Billing created successfully.');
    }
}
