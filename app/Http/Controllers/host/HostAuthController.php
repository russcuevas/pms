<?php

namespace App\Http\Controllers\host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostAuthController extends Controller
{
    public function HostLoginPage()
    {
        return view('host.auth.login');
    }
}
