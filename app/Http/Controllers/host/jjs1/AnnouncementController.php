<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
     public function HostJjs1AnnouncementPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        $announcements = DB::table('announcements')
            ->join('admins', 'announcements.admins_id', '=', 'admins.id')
            ->where('announcements.property_id', 2)
            ->orderBy('announcements.created_at', 'desc')
            ->select(
                'announcements.*',
                'admins.fullname as admin_name',
            )
            ->get();


        return view('host.jjs1.announcement', compact('host', 'announcements'));
    }

    public function HostJjs1AnnouncementApprove($id)
    {
        DB::table('announcements')
            ->where('id', $id)
            ->update([
                'is_approved' => 1,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Announcement approved successfully.');
    }

    public function HostJjs1AnnouncementDecline($id)
    {
        DB::table('announcements')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Announcement decline successfully');
    }

    public function HostJjs1AnnouncementDelete($id)
    {
        DB::table('announcements')
            ->where('id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Announcement delete successfully');
    }
}
