<?php

namespace App\Http\Controllers\tenant\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewBillingController extends Controller
{
public function TenantsJjs2MyBillingPage()
    {
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        if ($tenant->property_id != 3) {
            return redirect()->route('tenants.login.page')->with('error', 'Unauthorized property access.');
        }

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

        // Get billings
        $billings = DB::table('billings')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.tenant_id', $tenant->id)
            ->orderByDesc('billings.statement_date')
            ->select('billings.*', 'units.units_name')
            ->get();
            $notifications = DB::table('tenant_notifications')
                ->where('tenant_id', $tenant->id)
                ->where('property_id', $tenant->property_id)
                ->orderByDesc('created_at')
                ->get();

        return view('tenant.jjs2.view_billing', compact(
            'tenant',
            'unit',
            'property',
            'billings',
            'notifications'
        ));
    }
}
