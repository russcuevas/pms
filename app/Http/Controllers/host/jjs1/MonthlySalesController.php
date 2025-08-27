<?php

namespace App\Http\Controllers\host\jjs1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlySalesController extends Controller
{
        public function HostJjs1MonthlySalesComputation(Request $request)
    {
        $propertyId = 2;
        $year = $request->input('year', date('Y'));  // Default to current year if no year provided

        $sales = DB::table('monthly_sales')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_number"),
                DB::raw("SUM(amount) as total")
            )
            ->where('property_id', $propertyId)
            ->whereYear('created_at', $year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get();

        return response()->json([
            'sales' => $sales
        ]);
    }

    public function HostJjs1MonthlyExpensesComputation(Request $request)
    {
        $propertyId = 2;
        $year = $request->input('year', date('Y'));  // Default to current year if no year provided

        $expenses = DB::table('expenses')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_number"),
                DB::raw("SUM(total) as total")
            )
            ->where('property_id', $propertyId)
            ->whereYear('created_at', $year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get();

        return response()->json([
            'expenses' => $expenses
        ]);
    }

    public function HostJjs1MonthlyNetIncomeComputation(Request $request)
    {
        $propertyId = 2;
        $year = $request->input('year', date('Y'));

        // Fetch monthly sales
        $sales = DB::table('monthly_sales')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_number"),
                DB::raw("SUM(amount) as total")
            )
            ->where('property_id', $propertyId)
            ->whereYear('created_at', $year)
            ->groupBy('month_number')
            ->pluck('total', 'month_number');

        // Fetch monthly expenses
        $expenses = DB::table('expenses')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month_number"),
                DB::raw("SUM(total) as total")
            )
            ->where('property_id', $propertyId)
            ->whereYear('created_at', $year)
            ->groupBy('month_number')
            ->pluck('total', 'month_number');

        // Initialize net income array for all 12 months
        $netIncome = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthKey = str_pad($month, 2, '0', STR_PAD_LEFT); // Format: "01", "02", ..., "12"

            $salesAmount = isset($sales[$monthKey]) ? (float)$sales[$monthKey] : 0;
            $expensesAmount = isset($expenses[$monthKey]) ? (float)$expenses[$monthKey] : 0;
            $net = $salesAmount - $expensesAmount;

            $netIncome[] = [
                'month_number' => $monthKey,
                'sales' => $salesAmount,
                'expenses' => $expensesAmount,
                'net_income' => $net
            ];
        }

        return response()->json([
            'net_income' => $netIncome
        ]);
    }

    public function HostJjs1PaymentBreakdown(Request $request)
    {
        $propertyId = 2;
        $year = $request->input('year', date('Y'));

        $payments = DB::table('history_payments')
            ->select('mode_of_payment', DB::raw('SUM(amount) as total'))
            ->where('property_id', $propertyId)
            ->whereYear('created_at', $year)
            ->groupBy('mode_of_payment')
            ->pluck('total', 'mode_of_payment');

        $cashPayment = $payments['cash'] ?? 0;
        $onlinePayment = $payments['online payment'] ?? 0;
        $totalPayment = $cashPayment + $onlinePayment;

        return response()->json([
            'total_payment' => $totalPayment,
            'cash_payment' => $cashPayment,
            'online_payment' => $onlinePayment
        ]);
    }
}
