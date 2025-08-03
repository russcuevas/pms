<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function AdminLoginPage()
    {
        if (Auth::guard('admins')->check()) {
            $admin = Auth::guard('admins')->user();

            switch ($admin->property_id) {
                case 1:
                    return redirect()->route('admin.huberts.dashboard.page');
                case 2:
                    return redirect()->route('admin.jjs1.dashboard.page');
                case 3:
                    return redirect()->route('admin.jjs2.dashboard.page');
                default:
                    Auth::guard('admins')->logout();
                    return redirect()->route('admin.login.page')
                        ->withErrors(['login' => 'Unauthorized property access.'])
                        ->withInput();
            }
        }

        return view('admin.auth.login');
    }


    public function AdminLoginRequest(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            $admin = Auth::guard('admins')->user();

            switch ($admin->property_id) {
                case 1:
                    return redirect()->route('admin.huberts.dashboard.page')
                        ->with('success', 'Welcome Admin Huberts Residence');
                case 2:
                    return redirect()->route('admin.jjs1.dashboard.page')
                        ->with('success', 'Welcome Admin JJS1 Bldg');
                case 3:
                    return redirect()->route('admin.jjs2.dashboard.page')
                        ->with('success', 'Welcome Admin JJS2 Bldg');
                default:
                    Auth::guard('admins')->logout();
                    return redirect()->route('admin.login.page')
                        ->withErrors(['login' => 'Unauthorized property access.'])
                        ->withInput();
            }
        }

        return redirect()
            ->route('admin.login.page')
            ->withErrors(['login' => 'Invalid username or password'])
            ->withInput();
    }


    public function AdminLogoutRequest()
    {
        Auth::guard('admins')->logout();
        session()->flash('success', 'You have been logged out successfully.');
        return redirect()->route('admin.login.page');
    }
}
