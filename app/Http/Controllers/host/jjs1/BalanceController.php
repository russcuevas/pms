<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
     public function HostJjs1BalancePage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        // Subquery: latest billing IDs per tenant, but only for property_id = 1
        $latestBillingIds = DB::table('billings')
            ->where('property_id', 2)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('tenant_id');

        // Main query with joins, filtered by property_id = 1
        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', 1) // ensure final filter still applies
            ->select(
                'billings.*',
                'tenants.fullname',
                'units.units_name'
            )
            ->orderBy('billings.created_at', 'desc')
            ->get();

        return view('host.jjs1.balance', compact('host', 'billings'));
    }

    public function HostJjs1BalancePaidPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        $latestBillingIds = DB::table('billings')
            ->where('property_id', 2)
            ->where('status', 'paid')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', 1)
            ->where('billings.status', 'paid')
            ->select('billings.*', 'tenants.fullname', 'units.units_name')
            ->orderBy('billings.created_at', 'desc')
            ->get();

        return view('host.jjs1.paid_balance', compact('host', 'billings'));
    }

    public function HostJjs1BalanceDelinquentPage()
{
    if (!Auth::guard('hosts')->check()) {
        return redirect()->route('host.login.page')->with('error', 'Please log in.');
    }

    $host = Auth::guard('hosts')->user();

    // Get latest billing ID per tenant for property_id = 1
    $latestBillingIds = DB::table('billings')
        ->where('property_id', 2)
        ->select(DB::raw('MAX(id) as id'))
        ->groupBy('tenant_id');

    // Join and filter where the latest billing is delinquent
    $billings = DB::table('billings')
        ->joinSub($latestBillingIds, 'latest', function ($join) {
            $join->on('billings.id', '=', 'latest.id');
        })
        ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
        ->join('units', 'billings.unit_id', '=', 'units.id')
        ->where('billings.status', 'delinquent') // filter only if the latest billing is delinquent
        ->where('billings.property_id', 1)
        ->select('billings.*', 'tenants.fullname', 'units.units_name')
        ->orderBy('billings.created_at', 'desc')
        ->get();

    return view('host.jjs1.delinquent_balance', compact('host', 'billings'));
}
}
