<?php

namespace App\Http\Controllers\admin\hubert;

use App\Http\Controllers\Controller;
use App\Models\CashOnHand;
use App\Models\Payments;
use App\Models\TurnOver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function AdminHubertDashboardPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 1) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $totalCashOnHand = CashOnHand::where('property_id', 1)->sum('total_cash_amount');
        $totalCash = Payments::where('property_id', 1)
            ->where('mode_of_payment', 'cash')
            ->sum('amount');
        $totalOnline = Payments::where('property_id', 1)
            ->where('mode_of_payment', 'online payment')
            ->sum('amount');

        return view('admin.hubert.dashboard', compact('totalCashOnHand', 'totalCash', 'totalOnline'));
    }

    public function AdminHubertTurnOverMoney(Request $request)
    {
        $request->validate([
            'turn_over_money' => 'required|numeric|min:0.01',
        ]);

        $admin = Auth::guard('admins')->user();
        $totalCashOnHand = CashOnHand::where('property_id', $admin->property_id)->sum('total_cash_amount');

        if ($request->turn_over_money > $totalCashOnHand) {
            return response()->json([
                'message' => 'Insufficient balance. The current cash on hand is ₱' . number_format($totalCashOnHand, 2)
            ], 422);
        }

        TurnOver::create([
            'property_id' => $admin->property_id,
            'admin_fullname' => $admin->fullname,
            'turn_over_money' => $request->turn_over_money,
            'is_approved' => false,
        ]);

        return response()->json([
            'message' => 'Turn over request submitted successfully. Please wait for the receival of the host.'
        ]);
    }
}
