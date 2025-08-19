<?php

namespace App\Http\Controllers\tenant\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function TenantsHubertDashboardPage()
    {
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

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

        // Get latest billing
        $billing = DB::table('billings')
            ->where('tenant_id', $tenant->id)
            ->orderByDesc('created_at')
            ->first();

        $property = DB::table('properties')->where('id', 1)->first();
        
        $notifications = DB::table('tenant_notifications')
            ->where('tenant_id', $tenant->id)
            ->where('property_id', $tenant->property_id)
            // ->orderBy('is_view', 'asc')  // unread (0) first
            ->orderByDesc('created_at')
            // ->limit(10)
            ->get();

        return view('tenant.hubert.dashboard', [
            'tenant' => $tenant,
            'unit' => $unit,
            'property' => $property,
            'billing' => $billing,
            'notifications' => $notifications,  // <-- add this
        ]);
    }
}
