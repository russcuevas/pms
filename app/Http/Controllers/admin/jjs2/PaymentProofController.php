<?php

namespace App\Http\Controllers\admin\jjs2;

use App\Http\Controllers\Controller;
use App\Models\PaymentsProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentProofController extends Controller
{
        public function AdminJjs2PaymentProofPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 3) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $paymentProofs = PaymentsProof::where('property_id', 3)->get();

        return view('admin.jjs2.payment_proof', compact('paymentProofs'));
    }
}
