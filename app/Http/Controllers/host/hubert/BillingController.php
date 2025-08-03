<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function HostHubertBillingPage()
    {
        $units = DB::table('units')
            ->join('properties', 'units.property_id', '=', 'properties.id')
            ->where('units.property_id', 1)
            ->select('units.units_name', 'units.status', 'properties.property_name')
            ->get();

        return view('host.hubert.billing', compact('units'));
    }
}
