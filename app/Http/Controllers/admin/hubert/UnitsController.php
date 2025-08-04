<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnitsController extends Controller
{
    public function AdminUnitsManagementPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $units = DB::table('units')
            ->leftJoin('tenants', function ($join) {
                $join->on('units.id', '=', 'tenants.unit_id')
                    ->where('tenants.is_approved', true);
            })
            ->where('units.property_id', 1)
            ->select(
                'units.id as unit_id',
                'units.units_name',
                'units.status',
                'tenants.id as tenant_id',
                'tenants.fullname',
                'tenants.username',
                'tenants.email',
                'tenants.phone_number',
                'tenants.address',
                'tenants.move_in_date',
                'tenants.move_out_date',
                'tenants.created_at'
            )
            ->get();


        return view('admin.hubert.units_management', compact('units'));
    }
}
