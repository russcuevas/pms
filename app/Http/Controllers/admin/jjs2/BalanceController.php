<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function AdminJjs2BalancePage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $latestBillingIds = DB::table('billings')
            ->where('property_id', 3)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', 3)
            ->select(
                'billings.*',
                'tenants.fullname',
                'units.units_name'
            )
            ->orderBy('billings.created_at', 'desc')
            ->get();

        return view('admin.jjs2.balance', compact('billings'));
    }

    public function AdminJjs2BalancePaidPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $latestBillingIds = DB::table('billings')
            ->where('property_id', 3)
            ->where('status', 'paid')
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('tenant_id');

        $billings = DB::table('billings')
            ->joinSub($latestBillingIds, 'latest', function ($join) {
                $join->on('billings.id', '=', 'latest.id');
            })
            ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
            ->join('units', 'billings.unit_id', '=', 'units.id')
            ->where('billings.property_id', 3)
            ->where('billings.status', 'paid')
            ->select('billings.*', 'tenants.fullname', 'units.units_name')
            ->orderBy('billings.created_at', 'desc')
            ->get();

        return view('admin.jjs2.paid_balance', compact('billings'));
    }

    public function AdminJjs2BalanceDelinquentPage()
{
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

    $latestBillingIds = DB::table('billings')
        ->where('property_id', 3)
        ->select(DB::raw('MAX(id) as id'))
        ->groupBy('tenant_id');

    $billings = DB::table('billings')
        ->joinSub($latestBillingIds, 'latest', function ($join) {
            $join->on('billings.id', '=', 'latest.id');
        })
        ->join('tenants', 'billings.tenant_id', '=', 'tenants.id')
        ->join('units', 'billings.unit_id', '=', 'units.id')
        ->where('billings.status', 'delinquent')
        ->where('billings.property_id', 3)
        ->select('billings.*', 'tenants.fullname', 'units.units_name')
        ->orderBy('billings.created_at', 'desc')
        ->get();

    return view('admin.jjs2.delinquent_balance', compact('billings'));
}
}
