<?php

namespace App\Http\Controllers\tenant\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentProofController extends Controller
{
    public function TenantsJjs2MyPaymentRequest(Request $request)
    {
        $tenant = Auth::guard('tenants')->user();

        if (!$tenant) {
            return redirect()->route('tenants.login.page')->with('error', 'Please log in.');
        }

        // Validate file upload
        $request->validate([
            'payment_proof' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Handle file upload
        $filename = null;
        if ($request->hasFile('payment_proof')) {
            $filename = time() . '_' . $request->file('payment_proof')->getClientOriginalName();

            // Save into public/assets/huberts/proof_of_payment
            $request->file('payment_proof')->move(public_path('assets/jjs2/proof_of_payment'), $filename);
        }

        // Insert into payments_proofs
        DB::table('payments_proofs')->insert([
            'tenant_id'     => $tenant->id,
            'property_id'   => $tenant->property_id,
            'unit_id'       => $tenant->unit_id,
            'fullname'      => $tenant->fullname,
            'unit'          => $request->unit,
            'email'         => $tenant->email,
            'phone_number'  => $tenant->phone_number,
            'payment_proof' => $filename,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with('success', 'Payment proof submitted successfully!');
    }
}
