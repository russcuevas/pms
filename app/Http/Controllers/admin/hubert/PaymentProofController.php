<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentProof; // ✅ Add this
use App\Models\PaymentsProof;

class PaymentProofController extends Controller
{
    public function AdminHubertPaymentProofPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $paymentProofs = PaymentsProof::where('property_id', 1)->get();

        return view('admin.hubert.payment_proof', compact('paymentProofs'));
    }
}
