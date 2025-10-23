<?php

namespace App\Http\Controllers\ReportSummary;

use App\Http\Controllers\Controller;
use App\Models\Expense\ExpenseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ReportSummaryController extends Controller
{
    public function report_summary()
    {
        return view('admin.pages.report-summary.list');
    }

public function get_report_summary(Request $request)
{
    $request->validate([
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ], [
        'from_date.required' => 'Please select the from date.',
        'to_date.required'   => 'Please select the to date.',
    ]);

    $data = [
        'expenses' => DB::table('expenses')
            ->select(
                'id',
                'purpose_of_expense',
                'recipient_name',
                'amount_spent',
                'payment_mode',
                'expense_date',
                'financial_year',
                'remarks'
            )
            ->whereNull('deleted_at')
            ->whereBetween('expense_date', [$request->from_date, $request->to_date])
            ->orderBy('expense_date', 'asc')
            ->get(),

        'account_balances' => DB::table('account_balances')
            ->select('id', 'amount', 'created_at', 'updated_at')
            ->whereBetween('created_at', [$request->from_date, $request->to_date])
            ->orderBy('created_at', 'asc')
            ->get(),

        'bricks_sales' => DB::table('bricks_sales')
            ->select(
                'id',
                'bill_no',
                'customer_name',
                'quantity',
                'total_amount',
                'amount_received',
                'due_amount',
                'sale_date',
                'financial_year'
            )
            ->whereNull('deleted_at')
            ->whereBetween('sale_date', [$request->from_date, $request->to_date])
            ->orderBy('sale_date', 'asc')
            ->get(),

        'labour_payments' => DB::table('labour_payments')
            ->select(
                'id',
                'labour_id',
                'total_bricks',
                'current_payment',
                'total_payment',
                'paid_amount',
                'due_amount',
                'payment_date',
                'financial_year'
            )
            ->whereNull('deleted_at')
            ->whereBetween('payment_date', [$request->from_date, $request->to_date])
            ->orderBy('payment_date', 'asc')
            ->get(),

        'labour_work_details' => DB::table('labour_work_details')
            ->select(
                'id',
                'labour_id',
                'bricks_quantity',
                'work_date',
                'is_paid',
                'financial_year'
            )
            ->whereNull('deleted_at')
            ->whereBetween('work_date', [$request->from_date, $request->to_date])
            ->orderBy('work_date', 'asc')
            ->get(),

        'payments' => DB::table('payments')
            ->select(
                'id',
                'purchase_id',
                'party_id',
                'amount_paid',
                'due_amount',
                'total_amount',
                'payment_status',
                'payment_mode',
                'payment_date',
                'financial_year'
            )
            ->whereNull('deleted_at')
            ->whereBetween('payment_date', [$request->from_date, $request->to_date])
            ->orderBy('payment_date', 'asc')
            ->get(),

        'purchases' => DB::table('purchases')
            ->select(
                'id',
                'bill_no',
                'quantity',
                'unit',
                'total_amount',
                'payment_status',
                'date',
                'financial_year'
            )
            ->whereNull('deleted_at')
            ->whereBetween('date', [$request->from_date, $request->to_date])
            ->orderBy('date', 'asc')
            ->get(),

        'vehicle_payments' => DB::table('vehicle_payments')
            ->select(
                'id',
                'vehicle_id',
                'rent_amount',
                'paid_amount',
                'payment_date'
            )
            ->whereBetween('payment_date', [$request->from_date, $request->to_date])
            ->orderBy('payment_date', 'asc')
            ->get(),
    ];

    return view('admin.pages.report-summary.list', [
        'data' => $data,
        'selectedFromDate' => $request->from_date,
        'selectedToDate' => $request->to_date,
    ]);
}
}
