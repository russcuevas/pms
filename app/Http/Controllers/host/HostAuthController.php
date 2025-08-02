<?php

namespace App\Http\Controllers\host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostAuthController extends Controller
{
    public function HostLoginPage()
    {
        if (Auth::guard('hosts')->check()) {
            return redirect()->route('host.home.page');
        }

        return view('host.auth.login');
    }

    public function HostLoginRequest(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('hosts')->attempt($credentials)) {
            return redirect()->route('host.home.page');
        }

        return redirect()
            ->route('host.login.page')
            ->withErrors(['login' => 'Invalid username or password'])
            ->withInput();
    }

    public function HostLogoutRequest()
    {
        Auth::guard('hosts')->logout();
        return redirect()->route('host.login.page');
    }
}
