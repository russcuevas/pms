<?php

namespace App\Http\Controllers\tenant\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function TenantsJjs1DashboardPage()
    {
        return view('tenant.jjs1.dashboard');
    }
}
