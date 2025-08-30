<?php

namespace App\Http\Controllers\host\jjs2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TurnOverController extends Controller
{
        public function Jjs2TurnOverPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();
        $turnOvers = DB::table('turn_overs')
            ->where('property_id', 3)
            ->orderByDesc('created_at')
            ->get();

        return view('host.jjs2.turn_overs', compact('host', 'turnOvers'));
    }

    public function Jjs2TurnOverApproveRequest($id)
    {
        $turnOver = DB::table('turn_overs')->where('id', $id)->first();

        if (!$turnOver || $turnOver->is_approved) {
            return redirect()->back()->with('error', 'Invalid or already approved turnover.');
        }

        $cash = DB::table('cash_on_hands')->where('property_id', $turnOver->property_id)->first();

        if (!$cash) {
            return redirect()->back()->with('error', 'No cash on hand record found.');
        }

        if ($turnOver->turn_over_money > $cash->total_cash_amount) {
            return redirect()->back()->with('error', 'Turnover amount exceeds available cash on hand.');
        }

        $newTotal = $cash->total_cash_amount - $turnOver->turn_over_money;

        DB::transaction(function () use ($id, $newTotal, $cash) {
            DB::table('turn_overs')->where('id', $id)->update(['is_approved' => 1]);
            DB::table('cash_on_hands')->where('id', $cash->id)->update(['total_cash_amount' => $newTotal]);
        });

        return redirect()->back()->with('success', 'Turnover marked as received and amount deducted.');
    }


    public function Jjs2TurnOverDeclineRequest($id)
    {
        DB::table('turn_overs')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Turnover declined and deleted.');
    }
}
