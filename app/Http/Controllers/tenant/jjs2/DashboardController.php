<?php

namespace App\Http\Controllers\tenant\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function TenantsJjs2DashboardPage()
    {
        return view('tenant.jjs2.dashboard');
    }
}
