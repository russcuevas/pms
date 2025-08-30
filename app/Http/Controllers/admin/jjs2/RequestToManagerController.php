<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestToManagerController extends Controller
{
    public function AdminJjs2RequestToManagerPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $request_to_managers = DB::table('request_to_managers')
            ->join('admins', 'request_to_managers.admins_id', '=', 'admins.id')
            ->where('request_to_managers.property_id', 3)
            ->orderBy('request_to_managers.created_at', 'desc')
            ->select(
                'request_to_managers.*',
                'admins.fullname as admin_name',
            )
            ->get();

        return view('admin.jjs2.request_to_manager', compact('request_to_managers'));
    }

    public function AdminJjs2RequestToManagerRequest(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must login first');
        }

        $request->validate([
            'request_subject' => 'required|string|max:255',
            'request_message' => 'required|string'
        ]);

        DB::table('request_to_managers')->insert([
            'property_id' => 3,
            'admins_id' => $admin->id,
            'request_subject' => $request->request_subject,
            'request_message' => $request->request_message,
            'is_approved' => false,
            'created_at'  => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Request submitted successfully wait for the approval of the host');
    }
}
