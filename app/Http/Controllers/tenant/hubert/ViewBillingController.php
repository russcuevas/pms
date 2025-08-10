<?php

namespace App\Http\Controllers\tenant\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Billings;

class ViewBillingController extends Controller
{
    public function TenantsHubertMyBillingPage()
    {
        $tenant = Auth::guard('tenants')->user();

        // Require login
        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        // Only allow property_id = 1
        if ($tenant->property_id != 1) {
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

        // Get billings
        $billings = DB::table('billings')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.tenant_id', $tenant->id)
            ->orderByDesc('billings.statement_date')
            ->select('billings.*', 'units.units_name')
            ->get();


        return view('tenant.hubert.view_billing', compact(
            'tenant',
            'unit',
            'property',
            'billings'
        ));
    }
}
