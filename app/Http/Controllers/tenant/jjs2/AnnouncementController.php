<?php

namespace App\Http\Controllers\tenant\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function TenantsJjs2AnnouncementPage()
    { {
            $tenant = Auth::guard('tenants')->user();

            if (!$tenant) {
                return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
            }

            if ($tenant->property_id != 3) {
                return redirect()->route('tenants.login.page')->with('error', 'Unauthorized property access.');
            }

            // Get unit
            $unit = DB::table('units')
                ->where('id', $tenant->unit_id)
                ->where('property_id', $tenant->property_id)
                ->first();

            // Get property
            $property = DB::table('properties')
                ->where('id', $tenant->property_id)
                ->first();

            if (!$unit || !$property) {
                return redirect()->route('tenants.login.page')->with('error', 'Unauthorized access.');
            }

            $property = DB::table('properties')->where('id', 3)->first();

            $announcements = DB::table('announcements')
                ->join('admins', 'announcements.admins_id', '=', 'admins.id')
                ->where('announcements.property_id', 3)
                ->where('announcements.is_approved', 1)
                ->orderBy('announcements.created_at', 'desc')
                ->select(
                    'announcements.*',
                    'admins.fullname as admin_name'
                )
                ->get();

            $notifications = DB::table('tenant_notifications')
                ->where('tenant_id', $tenant->id)
                ->where('property_id', $tenant->property_id)
                ->orderByDesc('created_at')
                ->get();


            return view('tenant.jjs2.announcement', [
                'tenant' => $tenant,
                'unit' => $unit,
                'property' => $property,
                'announcements' => $announcements,
                'notifications'=> $notifications
            ]);
        }
    }
}
