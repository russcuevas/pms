<?php

namespace App\Http\Controllers\host\hubert;

use App\Http\Controllers\Controller;
use App\Models\PaymentsProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentProofController extends Controller
{
    public function HostHubertPaymentProofPage()
    {
        // Session
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        $paymentProofs = PaymentsProof::where('property_id', 1)->get();


        return view('host.hubert.payment_proof', compact('host', 'paymentProofs'));
    }
}
