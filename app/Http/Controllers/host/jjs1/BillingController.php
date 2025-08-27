<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function HostJjs1BillingPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }
        $propertyId = 2;

        $latestBillingIds = DB::table('billings')
            ->select(DB::raw('MAX(id) as latest_id'))
            ->where('property_id', $propertyId)
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.latest_id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', $propertyId)
            ->select(
                'billings.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name'
            )
            ->orderByDesc('billings.created_at')
            ->get();

        return view('host.jjs1.billing', compact('billings'));
    }

    public function HostJjs1ViewPreviousBillings($tenantId)
    {
        $propertyId = 2;

        $billings = DB::table('billings')
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.tenant_id', $tenantId)
            ->where('billings.property_id', $propertyId)
            ->select(
                'billings.*',
                'tenants.fullname as tenant_name',
                'units.units_name'
            )
            ->orderByDesc('billings.created_at')
            ->get();

        $groupedBillings = $billings->groupBy('for_the_month_of');

        if ($groupedBillings->isEmpty()) {
            return back()->with('error', 'No previous billings found for this tenant.');
        }

        return view('host.jjs1.previous_billings', compact('groupedBillings'));
    }

}
