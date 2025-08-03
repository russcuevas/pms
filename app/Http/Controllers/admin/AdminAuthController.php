<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

            if (!$admin->is_approved) {
                Auth::guard('admins')->logout();
                return redirect()
                    ->route('admin.login.page')
                    ->with('error', 'Your account is not yet verified.')
                    ->withInput();
            }

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
                        ->with('error', 'Unauthorized property access.')
                        ->withInput();
            }
        }

        return redirect()
            ->route('admin.login.page')
            ->with('error', 'Invalid username or password')
            ->withInput();
    }



    public function AdminLogoutRequest()
    {
        Auth::guard('admins')->logout();
        session()->flash('success', 'You have been logged out successfully.');
        return redirect()->route('admin.login.page');
    }

    public function AdminRegisterPage()
    {
        $properties = Properties::all();
        return view('admin.auth.register', compact('properties'));
    }

    public function AdminRegisterRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:admins,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:admins,email',
            'phone_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'property_id' => 'required|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        Admins::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'property_id' => $request->property_id,
            'is_approved' => false,
        ]);

        return redirect()
            ->route('admin.register.page')
            ->with('success', 'Registration successful! Please wait for the host approval.');
    }
}
