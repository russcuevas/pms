<?php

namespace App\Http\Controllers\tenant\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function TenantsHubertAnnouncementPage()
    { {
            $tenant = Auth::guard('tenants')->user();

            if (!$tenant) {
                return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
            }

            if ($tenant->property_id != 1) {
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

            $property = DB::table('properties')->where('id', 1)->first();

            $announcements = DB::table('announcements')
                ->join('admins', 'announcements.admins_id', '=', 'admins.id')
                ->where('announcements.property_id', 1)
                ->where('announcements.is_approved', 1)
                ->orderBy('announcements.created_at', 'desc')
                ->select(
                    'announcements.*',
                    'admins.fullname as admin_name'
                )
                ->get();


            return view('tenant.hubert.announcement', [
                'tenant' => $tenant,
                'unit' => $unit,
                'property' => $property,
                'announcements' => $announcements
            ]);
        }
    }
}
