<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function HostHubertDashboardPage()
    {
        // Session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        return view('host.hubert.dashboard', compact('host'));
    }
}
