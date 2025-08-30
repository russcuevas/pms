<?php

namespace App\Http\Controllers\tenant\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function TenantsJjs1MyRequestPage()
    {
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        if ($tenant->property_id != 2) {
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

        // Get requests
        $requests = DB::table('requests')
            ->where('tenant_id', $tenant->id)
            ->where('property_id', $tenant->property_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = DB::table('tenant_notifications')
                ->where('tenant_id', $tenant->id)
                ->where('property_id', $tenant->property_id)
                ->orderByDesc('created_at')
                ->get();

        return view('tenant.jjs1.request', compact(
            'tenant',
            'unit',
            'property',
            'requests',
            'notifications'
        ));
    }

    public function TenantsJjs1RequestPost(Request $request)
    {
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        if ($tenant->property_id != 2) {
            return redirect()->route('tenants.login.page')->with('error', 'Unauthorized property access.');
        }

        // Get unit
        $unit = DB::table('units')
            ->where('id', $tenant->unit_id)
            ->where('property_id', $tenant->property_id)
            ->first();

        // Validate form
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save request
        DB::table('requests')->insert([
            'property_id'     => $tenant->property_id,
            'unit_id' => $tenant->unit_id,
            'tenant_id'       => $tenant->id,
            'subject_request' => $validated['subject'],
            'subject_message' => $validated['message'],
            'status'          => 'Pending',
            'is_approved'     => false,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->back()->with('success', 'Your request has been submitted successfully please wait for the approval of the admin');
    }
}
