<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function HostHubertAdminPage()
    {
        // session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $admins = Admins::where('property_id', 1)->get();
        return view('host.hubert.admin_management', compact('admins'));
    }

    public function HostHubertUpdateApproval(Request $request, $id)
    {
        // session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $admin = Admins::findOrFail($id);

        if ($request->action === 'approve') {
            $admin->is_approved = 1;
            $admin->save();
        } elseif ($request->action === 'decline') {
            $admin->delete();
        }

        return back()->with('success', 'Admin status updated.');
    }
}
