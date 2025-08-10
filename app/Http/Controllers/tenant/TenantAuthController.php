<?php

namespace App\Http\Controllers\tenant;

use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\Tenants;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


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
                    return redirect()->route('tenants.huberts.dashboard.page')
                        ->with('success', 'Welcome Tenants Huberts Residence');
                case 2:
                    return redirect()->route('tenants.jjs1.dashboard.page')
                        ->with('success', 'Welcome Tenants JJS 1 Building');

                case 3:
                    return redirect()->route('tenants.jjs2.dashboard.page')
                        ->with('success', 'Welcome Tenants JJS 2 Building');

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
        $units = Units::where('status', 'vacant')->get();
        return view('tenant.auth.register', compact('properties', 'units'));
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
            'advance_deposit' => 'required',
            'contact_fullname' => 'required',
            'contact_phone_number' => 'required',
            'unit_name' => 'required|string',
            'move_in_date' => 'required|date',
            'move_out_date' => 'nullable|date|after_or_equal:move_in_date',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        $unit = Units::where('units_name', $request->unit_name)
            ->where('property_id', $request->property_id)
            ->where('status', 'vacant')
            ->first();

        if (!$unit) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'The unit name you entered does not exist or is not vacant for the selected property.');
        }

        $otp_code = mt_rand(1000, 9999);

        $tenant = Tenants::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'property_id' => $request->property_id,
            'unit_id' => $unit->id,
            'advance_deposit' => $request->advance_deposit,
            'contact_fullname' => $request->contact_fullname,
            'contact_phone_number' => $request->contact_phone_number,
            'move_in_date' => $request->move_in_date,
            'move_out_date' => $request->move_out_date,
            'otp_code' => $otp_code,
            'is_approved' => false,
        ]);

        Mail::raw("This is the OTP for your AVA account registration: {$otp_code}\n\nClick here to verify:\nhttp://127.0.0.1:8000/tenants/verify-otp", function ($message) use ($tenant) {
            $message->to($tenant->email)
                ->subject('Your AVA Registration OTP Code');
        });

        return redirect()
            ->route('tenants.register.page')
            ->with('success', 'Registration successful! Please check your email for the OTP verification code.');
    }


    public function TenantsOtpPage()
    {
        return view('tenant.auth.otp_verification');
    }

    public function TenantsVerifyOtp(Request $request)
    {
        $tenant = Tenants::where('otp_code', $request->otp_code)->first();

        if (!$tenant) {
            return redirect()
                ->route('tenants.otp.page')
                ->with('error', 'Invalid OTP')
                ->withInput();
        }

        $tenant->is_approved = true;
        $tenant->otp_code = null;
        $tenant->save();

        $unit = Units::where('id', $tenant->unit_id)
            ->where('property_id', $tenant->property_id)
            ->first();

        if ($unit) {
            $unit->status = 'occupied';
            $unit->save();
        }

        return redirect()->route('tenants.login.page')
            ->with('success', 'OTP verified. You can now log in.');
    }
}
