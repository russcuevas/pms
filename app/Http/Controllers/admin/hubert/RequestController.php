<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function AdminHubertRequestPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $requests = DB::table('requests')
            ->join('tenants', 'requests.tenant_id', '=', 'tenants.id')
            ->join('units', 'requests.unit_id', '=', 'units.id')
            ->where('requests.property_id', 1)
            ->orderBy('requests.created_at', 'desc')
            ->select(
                'requests.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name'
            )
            ->get();


        return view('admin.hubert.request', compact('requests'));
    }

    public function AdminHubertRequestApprove($id)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')->with('error', 'Unauthorized');
        }

        DB::table('requests')
            ->where('id', $id)
            ->update([
                'is_approved' => 1,
                'status' => 'Waiting to address by the host',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Request approved successfully.');
    }

    public function AdminHubertRequestDecline($id)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')->with('error', 'Unauthorized');
        }

        DB::table('requests')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Request declined and removed.');
    }
}
