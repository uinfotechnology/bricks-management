<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense\ExpenseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function createExpenseView()
    {
        return view('admin.pages.expense.create');
    }

    public function createExpense(Request $request)
    {
        $request->validate([
            'purpose_of_expense' => 'required|string|max:255',
            'recipient_name'     => 'nullable|string|max:255',
            'amount_spent'       => 'required|numeric|min:0',
            'payment_mode'       => 'nullable|string|max:255',
            'expense_date'       => 'required|date',
            'remarks'            => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $accountBalance = DB::table('account_balances')->first();

            if (!$accountBalance) {
                return redirect()->back()->with('error', 'Account balance not found.');
            }

            if ($accountBalance->amount < $request->amount_spent) {
                return redirect()->back()->with('error', 'Insufficient account balance.');
            }

            $expense = new ExpenseModel();
            $expense->purpose_of_expense = $request->purpose_of_expense;
            $expense->recipient_name     = $request->recipient_name;
            $expense->amount_spent       = $request->amount_spent;
            $expense->payment_mode       = $request->payment_mode;
            $expense->expense_date       = $request->expense_date;
            $expense->remarks            = $request->remarks;
            $expense->financial_year     = session('financial_year')['name'] ?? null;

            $expense->save();

            DB::table('account_balances')
                ->where('id', $accountBalance->id)
                ->update([
                    'amount'     => $accountBalance->amount - $request->amount_spent,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return redirect()->route('admin.expense.expenseList')
                ->with('success', 'Expense Created Successfully and Account Balance Updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function expenseList(Request $request)
    {
        if ($request->ajax()) {
            $list = ExpenseModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.expense.editExpense', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.expense.deleteExpense', Crypt::encrypt($row->id));
                    return '
                    <a class="btn btn-sm btn-warning" href="' . $editRoute . '">Edit</a>
                    <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure want to delete this data?\')">Delete</button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.expense.list');
    }

    public function editExpense($id)
    {
        try {
            $expenseId = Crypt::decrypt($id);
            $expense = ExpenseModel::findOrFail($expenseId);
            return view('admin.pages.expense.edit', compact('expense'));
        } catch (\Exception $e) {
            return redirect()->route('admin.expense.expenseList')
                ->with('error', 'Invalid Expense ID');
        }
    }

    public function updateExpense(Request $request, $id)
    {
        try {
            $expenseId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid expense ID!');
        }

        $expense = ExpenseModel::findOrFail($expenseId);

        $request->validate([
            'purpose_of_expense' => 'required|string|max:255',
            'recipient_name'     => 'nullable|string|max:255',
            'amount_spent'       => 'required|numeric|min:0',
            'payment_mode'       => 'nullable|string|max:255',
            'expense_date'       => 'required|date',
            'remarks'            => 'nullable|string|max:255',
        ]);

        $expense->update([
            'purpose_of_expense' => $request->purpose_of_expense,
            'recipient_name'     => $request->recipient_name,
            'amount_spent'       => $request->amount_spent,
            'payment_mode'       => $request->payment_mode,
            'expense_date'       => $request->expense_date,
            'remarks'            => $request->remarks,
        ]);

        return redirect()->route('admin.expense.expenseList')
            ->with('success', 'Expense updated successfully.');
    }

    public function deleteExpense($id)
    {
        $id = Crypt::decrypt($id);
        $data = ExpenseModel::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.expense.expenseList')->with('success', 'Expense deleted successfully!');
    }

    public function expense_filter()
    {
        return view('admin.pages.expense.filtar-data-list');
    }

    public function get_expense_filter(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ], [
            'from_date.required' => 'Please select the from date.',
            'to_date.required'   => 'Please select the to date.',
        ]);

        $expenses = DB::table('expenses')
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
            ->get();

        return view('admin.pages.expense.filtar-data-list', [
            'expenses' => $expenses,
            'selectedFromDate' => $request->from_date,
            'selectedToDate' => $request->to_date,
        ]);
    }
}
