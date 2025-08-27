<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
        public function HostJjs1ExpensesPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $host = Auth::guard('hosts')->user();

        // Get expenses where property_id = 1
        $expenses = DB::table('expenses')
            ->where('property_id', 2)
            ->orderByDesc('date')
            ->get();

        return view('host.jjs1.expenses', compact('host', 'expenses'));
    }


    public function HostJjs1ApprovedRequest($id)
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        // Get the expense where property_id = 1 and expense id = $id
        $expense = DB::table('expenses')
            ->where('id', $id)
            ->where('property_id', 2)
            ->first();

        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found or unauthorized.');
        }

        // Update expense as approved
        DB::table('expenses')->where('id', $id)->update(['is_approved' => true]);

        // Deduct expense total from cash_on_hand
        $cashOnHand = DB::table('cash_on_hands')
            ->where('property_id', $expense->property_id)
            ->first();

        if ($cashOnHand) {
            $newAmount = $cashOnHand->total_cash_amount - $expense->total;
            DB::table('cash_on_hands')
                ->where('id', $cashOnHand->id)
                ->update(['total_cash_amount' => $newAmount]);
        } else {
            // If no cash_on_hand record, create one with negative balance
            DB::table('cash_on_hands')->insert([
                'property_id' => $expense->property_id,
                'total_cash_amount' => 0 - $expense->total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Expense approved and cash on hand updated.');
    }


    public function HostJjs1DeclineRequest($id)
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        // Get the expense where property_id = 1 and expense id = $id
        $expense = DB::table('expenses')
            ->where('id', $id)
            ->where('property_id', 2)
            ->first();

        if (!$expense) {
            return redirect()->back()->with('error', 'Expense not found or unauthorized.');
        }

        // Delete the expense (declined)
        DB::table('expenses')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Expense declined and deleted.');
    }

        public function HostJjs1ExpensesPrintPage()
    {
        if (!Auth::guard('hosts')->check()) {
            return redirect()->route('host.login.page')->with('error', 'Please log in.');
        }

        $expenses = DB::table('expenses')
            ->where('property_id', 2)
            ->where('is_approved', 1)
            ->orderByDesc('date')
            ->get();

        return view('host.jjs1.print.expenses', compact('expenses'));
    }
}
