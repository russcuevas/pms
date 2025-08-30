<?php

namespace App\Http\Controllers\host\jjs2;

use App\Http\Controllers\Controller;
use App\Models\PaymentsProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentProofController extends Controller
{
    public function HostJjs2PaymentProofPage()
    {
        // Session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        $paymentProofs = PaymentsProof::where('property_id', 3)->get();


        return view('host.jjs2.payment_proof', compact('host', 'paymentProofs'));
    }
}
