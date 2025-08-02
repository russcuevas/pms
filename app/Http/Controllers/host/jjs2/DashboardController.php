<?php

namespace App\Http\Controllers\host\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function HostJjs2DashboardPage()
    {
        // Session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->withErrors(['login' => 'Please log in.']);
        }

        $host = Auth::guard('hosts')->user();
        return view('host.jjs2.dashboard', compact('host'));
    }
}
