<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Don't forget this

class RequestController extends Controller
{
    public function HostHubertRequestPage()
    {
        // Session check
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        // Fetch approved requests for property_id = 1 with tenant fullname and unit name
        $requests = DB::table('requests')
            ->join('tenants', 'requests.tenant_id', '=', 'tenants.id')
            ->join('units', 'requests.unit_id', '=', 'units.id')
            ->where('requests.property_id', 1)
            ->where('requests.is_approved', 1) // Only approved requests
            ->orderBy('requests.created_at', 'desc')
            ->select(
                'requests.*',
                'tenants.fullname as tenant_name',
                'units.units_name as unit_name'
            )
            ->get();

        return view('host.hubert.request', compact('host', 'requests'));
    }


    public function HostHubertRequestAddressRequest(Request $request, $id)
    {
        $action = $request->input('action');

        if ($action === 'addressed') {
            DB::table('requests')->where('id', $id)->update([
                'status' => 'Already addressed',
                'updated_at' => now()
            ]);
            return redirect()->back()->with('success', 'Request marked as already addressed.');
        }

        if ($action === 'not_addressed') {
            DB::table('requests')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Request deleted successfully.');
        }

        return redirect()->back()->with('error', 'Invalid action.');
    }
}
