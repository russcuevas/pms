<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function AdminJjs2AnnouncementPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $announcements = DB::table('announcements')
            ->where('announcements.property_id', 3)
            ->orderBy('announcements.created_at', 'desc')
            ->select(
                'announcements.*',
            )
            ->get();

        return view('admin.jjs2.announcement', compact('announcements'));
    }

    public function AdminJjs2AnnouncementRequest(Request $request)
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must login first');
        }

        $request->validate([
            'announcement_subject' => 'required|string|max:255',
            'announcement_message' => 'required|string'
        ]);

        DB::table('announcements')->insert([
            'property_id' => 3,
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
