<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestToManagerController extends Controller
{
    public function HostHubertRequestToManagerPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        $request_to_managers = DB::table('request_to_managers')
            ->join('admins', 'request_to_managers.admins_id', '=', 'admins.id')
            ->where('request_to_managers.property_id', 1)
            ->orderBy('request_to_managers.created_at', 'desc')
            ->select(
                'request_to_managers.*',
                'admins.fullname as admin_name',
            )
            ->get();


        return view('host.hubert.request_to_manager', compact('host', 'request_to_managers'));
    }

    public function HostHubertRequestToManagerApprove($id)
    {
        DB::table('request_to_managers')
            ->where('id', $id)
            ->update([
                'is_approved' => 1,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Request by admin approved successfully.');
    }

    public function HostHubertRequestToManagerDecline($id)
    {
        DB::table('request_to_managers')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Request by admin declined and removed.');
    }

    public function HostHubertRequestToManagerDelete($id)
    {
        DB::table('request_to_managers')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Request by admin deleted successfully.');
    }
}
