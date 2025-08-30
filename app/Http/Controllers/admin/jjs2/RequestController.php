<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function AdminJjs2RequestPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $requests = DB::table('requests')
            ->join('tenants', 'requests.tenant_id', '=', 'tenants.id')
            ->join('units', 'requests.unit_id', '=', 'units.id')
            ->where('requests.property_id', 3)
            ->orderBy('requests.created_at', 'desc')
            ->select(
                'requests.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name'
            )
            ->get();


        return view('admin.jjs2.request', compact('requests'));
    }

    public function AdminJjs2RequestApprove($id)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
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

    public function AdminJjs2RequestDecline($id)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')->with('error', 'Unauthorized');
        }

        DB::table('requests')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Request declined and removed.');
    }
}
