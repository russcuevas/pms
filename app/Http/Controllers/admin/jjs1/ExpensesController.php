<?php

namespace App\Http\Controllers\admin\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function AdminJjs1ExpensesPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 2) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $expenses = DB::table('expenses')
            ->where('property_id', 2)
            ->where('is_approved', 1)
            ->orderByDesc('date')
            ->get();

        return view('admin.jjs1.expenses', compact('expenses'));
    }

    public function AdminJjs1ExpensesRequest(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'salaries' => 'required|string',
            'labor_for_repair' => 'required|string',
            'materials' => 'required|string',
            'food' => 'required|string',
            'taxes' => 'required|string',
            'miscellaneous' => 'required|string',
            'water_electricity' => 'required|string',
            'refund' => 'required',
            'office_supplies' => 'required',
            'remarks' => 'nullable|string',
            'total' => 'required|numeric',
            'property_id' => 'nullable|exists:properties,id',
        ]);

        DB::table('expenses')->insert([
            'date' => $request->date,
            'salaries' => $request->salaries,
            'labor_for_repair' => $request->labor_for_repair,
            'materials' => $request->materials,
            'food' => $request->food,
            'taxes' => $request->taxes,
            'miscellaneous' => $request->miscellaneous,
            'water_electricity' => $request->water_electricity,
            'refund' => $request->refund,
            'office_supplies' => $request->office_supplies,
            'remarks' => $request->remarks,
            'total' => $request->total,
            'property_id' => $request->property_id,
            'is_approved' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Expense requested successfully please wait for the approval of the host.');
    }

    public function AdminJjs1ExpensesPrintPage()
    {
        $admin = Auth::guard('admins')->user();

        if (!$admin || $admin->property_id != 2) {
            return redirect()->route('admin.login.page')
                ->with('error', 'You must log in first');
        }

        $expenses = DB::table('expenses')
            ->where('property_id', 2)
            ->where('is_approved', 1)
            ->orderByDesc('date')
            ->get();

        return view('admin.jjs1.print.expenses', compact('expenses'));
    }
}
