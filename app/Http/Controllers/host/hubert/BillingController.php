<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function HostHubertBillingPage()
    {
        $latestBillingIds = DB::table('billings')
            ->select(DB::raw('MAX(id) as latest_id'))
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.latest_id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->select(
                'billings.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name'
            )
            ->orderByDesc('billings.created_at')
            ->get();

        return view('host.hubert.billing', compact('billings'));
    }

    public function HostHubertViewPreviousBillings($tenantId)
    {
        $billings = DB::table('billings')
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->select(
                'billings.*',
                'tenants.fullname as tenant_name',
                'units.units_name'
            )
            ->where('billings.tenant_id', $tenantId)
            ->orderByDesc('billings.created_at')
            ->get();

        $groupedBillings = $billings->groupBy('for_the_month_of');

        if ($groupedBillings->isEmpty()) {
            return back()->with('error', 'No previous billings found for this tenant.');
        }

        return view('host.hubert.previous_billings', compact('groupedBillings'));
    }
}
