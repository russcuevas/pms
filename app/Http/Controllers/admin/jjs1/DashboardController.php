<?php

namespace App\Http\Controllers\admin\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function AdminJjs1DashboardPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 2) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        return view('admin.jjs1.dashboard');
    }
}
