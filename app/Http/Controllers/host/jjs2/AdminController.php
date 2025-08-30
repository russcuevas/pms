<?php

namespace App\Http\Controllers\host\jjs2;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function HostJjs2AdminPage()
    {
        // session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $admins = Admins::where('property_id', 3)->get();
        return view('host.jjs2.admin_management', compact('admins'));
    }

    public function HostJjs2UpdateApproval(Request $request, $id)
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
