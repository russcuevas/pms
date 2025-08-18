<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function AdminHubertBalancePage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $latestBillingIds = DB::table('billings')
            ->where('property_id', 1)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', 1)
            ->select(
                'billings.*',
                'tenants.fullname',
                'units.units_name'
            )
            ->orderBy('billings.created_at', 'desc')
            ->get();

        return view('admin.hubert.balance', compact('billings'));
    }

    public function AdminHubertBalancePaidPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $latestBillingIds = DB::table('billings')
            ->where('property_id', 1)
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

        return view('admin.hubert.paid_balance', compact('billings'));
    }

    public function AdminHubertBalanceDelinquentPage()
{
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

    $latestBillingIds = DB::table('billings')
        ->where('property_id', 1)
        ->select(DB::raw('MAX(id) as id'))
        ->groupBy('tenant_id');

    $billings = DB::table('billings')
        ->joinSub($latestBillingIds, 'latest', function ($join) {
            $join->on('billings.id', '=', 'latest.id');
        })
        ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
        ->join('units', 'billings.unit_id', '=', 'units.id')
        ->where('billings.status', 'delinquent')
        ->where('billings.property_id', 1)
        ->select('billings.*', 'tenants.fullname', 'units.units_name')
        ->orderBy('billings.created_at', 'desc')
        ->get();

    return view('admin.hubert.delinquent_balance', compact('billings'));
}
}
