<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\Tenants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantAuthController extends Controller
{
    public function TenantsLoginPage()
    {
        // if (Auth::guard('tenants')->check()) {
        //     $tenants = Auth::guard('tenants')->user();

        //     switch ($tenants->property_id) {
        //         case 1:
        //             return redirect()->route('tenants.huberts.dashboard.page');
        //         case 2:
        //             return redirect()->route('tenants.jjs1.dashboard.page');
        //         case 3:
        //             return redirect()->route('tenants.jjs2.dashboard.page');
        //         default:
        //             Auth::guard('tenants')->logout();
        //             return redirect()->route('tenants.login.page')
        //                 ->withErrors(['login' => 'Unauthorized property access.'])
        //                 ->withInput();
        //     }
        // }

        return view('tenant.auth.login');
    }


    public function TenantsLoginRequest(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('tenants')->attempt($credentials)) {
            $tenant = Auth::guard('tenants')->user();

            if (!$tenant->is_approved) {
                Auth::guard('tenants')->logout();
                return redirect()
                    ->route('tenants.login.page')
                    ->with('error', 'Your account is not yet verified check your email.')
                    ->withInput();
            }

            if (is_null($tenant->unit_id)) {
                Auth::guard('tenants')->logout();
                return redirect()
                    ->route('tenants.login.page')
                    ->with('error', 'You are not assigned to any unit. Contact admin.')
                    ->withInput();
            }

            // Route based on property
            switch ($tenant->property_id) {
                case 1:
                    return redirect()->route('tenants.huberts.dashboard.page');
                case 2:
                    return redirect()->route('tenants.jjs1.dashboard.page');
                case 3:
                    return redirect()->route('tenants.jjs2.dashboard.page');
                default:
                    Auth::guard('tenants')->logout();
                    return redirect()->route('tenants.login.page')
                        ->with('error', 'Unauthorized property access.')
                        ->withInput();
            }
        }

        return redirect()
            ->route('tenants.login.page')
            ->with('error', 'Invalid username or password')
            ->withInput();
    }



    public function TenantsLogoutRequest()
    {
        Auth::guard('tenants')->logout();
        session()->flash('success', 'You have been logged out successfully.');
        return redirect()->route('tenants.login.page');
    }

    public function TenantsRegisterPage()
    {
        $properties = Properties::all();
        return view('tenants.auth.register', compact('properties'));
    }

    public function TenantsRegisterRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:tenants,username',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:tenants,email',
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

        Tenants::create([
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
            ->route('tenants.register.page')
            ->with('success', 'Registration successful please check your email account for verification ');
    }
}
