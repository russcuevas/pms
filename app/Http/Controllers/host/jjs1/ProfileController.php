<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
        public function Jjs1ShowChangePasswordForm()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        return view('host.jjs1.profile');
    }

    public function Jjs1ChangePasswordRequest(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $host = Auth::guard('hosts')->user();

        if (!Hash::check($request->current_password, $host->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $host->password = Hash::make($request->new_password);
        $host->save();

        return back()->with('status', 'Password changed successfully!');
    }
}
