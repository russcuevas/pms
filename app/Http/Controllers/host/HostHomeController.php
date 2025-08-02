<?php

namespace App\Http\Controllers\host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostHomeController extends Controller
{
    public function HostHomePage()
    {
        // Session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->withErrors(['login' => 'Please log in.']);
        }

        $host = Auth::guard('hosts')->user();
        return view('host.home.home', compact('host'));
    }
}
