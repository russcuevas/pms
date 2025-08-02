<?php

namespace App\Http\Controllers\host;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostHomeController extends Controller
{
    public function HostHomePage()
    {
        return view('host.home.home');
    }
}
