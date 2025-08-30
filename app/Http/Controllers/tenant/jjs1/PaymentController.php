<?php

namespace App\Http\Controllers\tenant\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function TenantsJjs1MyPaymentPage()
    {
        // Get currently logged-in tenant
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        // Validate tenant belongs to Hubert's property (ID = 1)
        if ($tenant->property_id != 2) {
            return redirect()->route('tenants.login.page')->with('error', 'Unauthorized property access.');
        }

        // Get unit
        $unit = DB::table('units')
            ->where('id', $tenant->unit_id)
            ->where('property_id', $tenant->property_id)
            ->first();

        // Get property
        $property = DB::table('properties')
            ->where('id', $tenant->property_id)
            ->first();

        if (!$unit || !$property) {
            return redirect()->route('tenants.login.page')->with('error', 'Unauthorized access.');
        }

        // Retrieve payments made by this tenant
        $payments = DB::table('payments')
            ->join('units', 'payments.unit_id', '=', 'units.id')
            ->join('billings', 'payments.billings_id', '=', 'billings.id')
            ->where('payments.tenant_id', $tenant->id)
            ->select(
                'payments.*',
                'units.units_name as unit_name',
                'billings.soa_no'
            )
            ->orderByDesc('payments.created_at')
            ->get();

            $notifications = DB::table('tenant_notifications')
                ->where('tenant_id', $tenant->id)
                ->where('property_id', $tenant->property_id)
                ->orderByDesc('created_at')
                ->get();

        return view('tenant.jjs1.view_payment', compact(
            'tenant',
            'unit',
            'property',
            'payments',
            'notifications'
        ));
    }
}
