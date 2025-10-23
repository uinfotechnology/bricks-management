<?php

namespace App\Http\Controllers\LabourPayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Labour\LabourModel;
use App\Models\LabourPayment\LabourPaymentModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LabourPaymentController extends Controller
{
    public function createLabourPaymentView(Request $request)
    {
        $labour = LabourModel::orderBy('name', 'asc')->get();
        return view('admin.pages.labour-payment.create', compact('labour'));
    }

    public function getPreviousPayments(Request $request)
    {
        $labourId = $request->labour_id;

        if (!$labourId) {
            return response()->json([]);
        }

        $previousPayments = DB::table('labour_payments as lp')
            ->join('labours as l', 'lp.labour_id', '=', 'l.id')
            ->select(
                'lp.total_bricks',
                'lp.total_payment',
                'lp.paid_amount',
                'lp.due_amount',
                'lp.payment_date',
                'l.mobile_number'
            )
            ->where('lp.labour_id', $labourId)
            ->orderBy('lp.id', 'desc')
            ->take(3)
            ->get();

        return response()->json($previousPayments);
    }

    public function calculatePayment(Request $request)
    {
        $labourId = $request->labour_id;
        $totalBricks = 0;
        $totalPayment = 0;
        $previousDue = 0;
        $currentPayment = 0;

        if ($labourId) {
            $totalBricks = DB::table('labour_work_details')
                ->where('labour_id', $labourId)
                ->where('is_paid', 0)
                ->sum('bricks_quantity');

            $labour = LabourModel::find($labourId);
            $ratePerThousand = $labour ? $labour->rate_per_thousand : 0;

            $currentPayment = ($totalBricks / 1000) * $ratePerThousand;

            $previousDueQuery = DB::table('labour_payments')
                ->where('labour_id', $labourId)
                ->where('deleted_at', null)
                ->orderBy('id', 'desc')
                ->first();

            $previousDue = $previousDueQuery ? $previousDueQuery->due_amount : 0;

            $totalPayment = $currentPayment + $previousDue;
        }

        return response()->json([
            'totalBricks' => $totalBricks,
            'currentPayment' => number_format($currentPayment, 2),
            'previousDue' => number_format($previousDue, 2),
            'totalPayment' => number_format($totalPayment, 2)
        ]);
    }

    public function storeLabourPayment(Request $request)
    {
        $request->validate([
            'labour_id'     => 'required|integer',
            'paid_amount'   => 'required|numeric|min:0',
            'payment_date'  => 'required|date',
            'remarks'       => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $labourId   = $request->labour_id;
            $paidAmount = $request->paid_amount;

            $labour = LabourModel::find($labourId);
            if (!$labour) {
                return redirect()->back()->withErrors(['labour_id' => 'Invalid Labour']);
            }

            $ratePerThousand = $labour->rate_per_thousand;

            $totalBricks = DB::table('labour_work_details')
                ->where('labour_id', $labourId)
                ->where('is_paid', 0)
                ->sum('bricks_quantity');

            $currentPayment = ($totalBricks / 1000) * $ratePerThousand;

            $previousDueQuery = DB::table('labour_payments')
                ->where('labour_id', $labourId)
                ->whereNull('deleted_at')
                ->orderBy('id', 'desc')
                ->first();

            $previousDue = $previousDueQuery ? $previousDueQuery->due_amount : 0;

            $totalPayment = $currentPayment + $previousDue;
            $dueAmount = $totalPayment - $paidAmount;

            if ($dueAmount < 0) {
                return redirect()->back()->withErrors(['paid_amount' => 'Paid amount cannot exceed total payment']);
            }

            $accountBalance = DB::table('account_balances')->orderBy('id', 'desc')->first();

            if (!$accountBalance) {
                return redirect()->back()->withErrors(['account_balance' => 'Account balance record not found']);
            }

            if ($accountBalance->amount < $paidAmount) {
                return redirect()->back()->withErrors(['paid_amount' => 'Insufficient account balance']);
            }

            $newBalance = $accountBalance->amount - $paidAmount;
            DB::table('account_balances')
                ->where('id', $accountBalance->id)
                ->update(['amount' => $newBalance, 'updated_at' => now()]);

            $save = new LabourPaymentModel();
            $save->labour_id       = $labourId;
            $save->total_bricks    = $totalBricks;
            $save->current_payment = $currentPayment;
            $save->total_payment   = $totalPayment;
            $save->paid_amount     = $paidAmount;
            $save->due_amount      = $dueAmount;
            $save->payment_date    = $request->payment_date;
            $save->financial_year  = session('financial_year')['name'] ?? null;
            $save->remarks         = $request->remarks;
            $save->save();

            DB::table('labour_work_details')
                ->where('labour_id', $labourId)
                ->where('is_paid', 0)
                ->update(['is_paid' => 1]);

            DB::commit();

            return redirect()->route('admin.labourPayment.labourPaymentList')
                ->with('success', 'Labour Payment Created Successfully. ₹' . number_format($paidAmount, 2) . ' deducted from account. Current Payment: ₹' . number_format($currentPayment, 2) . ' | Remaining Due: ₹' . number_format($dueAmount, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function labourPaymentList(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table('labour_payments')
                ->join('labours', 'labour_payments.labour_id', '=', 'labours.id')
                ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->select(
                    'labour_payments.*',
                    'labours.name as labour_name',
                    'labours.mobile_number',
                    'labour_types.labour_type'
                )
                ->whereNull('labour_payments.deleted_at')
                ->orderBy('labour_payments.id', 'desc')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $deleteRoute = route('admin.labourPayment.deleteLabourPayment', Crypt::encrypt($row->id));
                    return '
                <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                    ' . csrf_field() . method_field("DELETE") . '
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure want to delete this labour?\')">Delete</button>
                </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.labour-payment.list');
    }

    public function labourPaymentFilter()
    {
        $labour = LabourModel::orderBy('id', 'desc')->get();
        return view('admin.pages.labour-payment.filtar-data-list', compact('labour'));
    }

    public function getLabourPaymentFilter(Request $request)
    {
        $request->validate([
            'labour_id' => 'required',
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ], [
            'labour_id.required' => 'The labour name field is required.',
            'from_date.date'     => 'The from date must be a valid date.',
            'to_date.date'       => 'The to date must be a valid date.',
            'to_date.after_or_equal' => 'The to date must be on or after the from date.',
        ]);

        $labour = LabourModel::orderBy('id', 'desc')->get();

        $paymentDetails = DB::table('labour_payments')
            ->join('labours', 'labour_payments.labour_id', '=', 'labours.id')
            ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
            ->select(
                'labour_payments.*',
                'labours.name as labour_name',
                'labours.mobile_number',
                'labours.image',
                'labours.address',
                'labours.city',
                'labours.state',
                'labours.gender',
                'labours.aadhar_no',
                'labours.pan_number',
                'labour_types.labour_type',
            )
            ->whereNull('labour_payments.deleted_at')
            ->where('labour_payments.labour_id', $request->labour_id)
            ->whereBetween('labour_payments.payment_date', [$request->from_date, $request->to_date])
            ->orderBy('labour_payments.payment_date', 'asc')
            ->get();

        return view('admin.pages.labour-payment.filtar-data-list', [
            'labour'           => $labour,
            'paymentDetails'   => $paymentDetails,
            'selectedLabourId' => $request->labour_id,
            'selectedFromDate' => $request->from_date,
            'selectedToDate'   => $request->to_date,
        ]);
    }

    public function deleteLabourPayment($id)
    {
        $id = Crypt::decrypt($id);
        $labourPayment = LabourPaymentModel::findOrFail($id);
        DB::table('labour_work_details as lwd')
            ->join('labour_payments as lp', 'lp.labour_id', '=', 'lwd.labour_id')
            ->where('lp.id', $labourPayment->id)
            ->whereBetween('lwd.work_date', [$labourPayment->from_date, $labourPayment->to_date])
            ->update(['lwd.is_paid' => 0]);
        $labourPayment->delete();

        return redirect()->route('admin.labourPayment.labourPaymentList')
            ->with('success', 'Labour payment deleted successfully!');
    }
}
