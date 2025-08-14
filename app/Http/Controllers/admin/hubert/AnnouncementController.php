<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function AdminHubertAnnouncementPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $announcements = DB::table('announcements')
            ->where('announcements.property_id', 1)
            ->orderBy('announcements.created_at', 'desc')
            ->select(
                'announcements.*',
            )
            ->get();

        return view('admin.hubert.announcement', compact('announcements'));
    }

    public function AdminHubertAnnouncementRequest(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must login first');
        }

        $request->validate([
            'announcement_subject' => 'required|string|max:255',
            'announcement_message' => 'required|string'
        ]);

        DB::table('announcements')->insert([
            'property_id' => 1,
            'admins_id' => $admin->id,
            'announcement_subject' => $request->announcement_subject,
            'announcement_message' => $request->announcement_message,
            'is_approved' => false,
            'created_at'  => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Announcement submitted successfully wait for the approval of the host');
    }
}
