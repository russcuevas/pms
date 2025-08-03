<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function AdminJjs2DashboardPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        return view('admin.jjs2.dashboard');
    }
}
