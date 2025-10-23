<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment\PaymentModel;
use App\Models\Purchase\PurchaseModel;
use App\Models\Account\AccountModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function createPayment($id)
    {
        try {
            $purchase_id = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid purchase ID!');
        }

        $purchase = DB::table('purchases')
            ->select(
                'purchases.id',
                'purchases.bill_no',
                'purchases.total_amount',
                'purchases.party_id',
                'purchases.date',
                'account.party_name'
            )
            ->leftJoin('account', 'purchases.party_id', '=', 'account.id')
            ->where('purchases.id', $purchase_id)
            ->first();

        if (!$purchase) {
            return redirect()->back()->with('error', 'Purchase record not found!');
        }

        $total_paid = DB::table('payments')
            ->where('purchase_id', $purchase_id)
            ->sum('amount_paid');

        // Calculate due amount
        $due_amount = $purchase->total_amount - $total_paid;

        return view('admin.pages.payment.create', compact('purchase', 'due_amount', 'total_paid'));
    }

    // save payment
    public function storePayment(Request $request)
    {
        $request->validate([
            'purchase_id'   => 'required|exists:purchases,id',
            'party_id'      => 'required|exists:account,id',
            'amount_paid'   => 'required|numeric|min:0',
            'payment_mode'  => 'required|string',
            'payment_date'  => 'required|date',
            'remarks'       => 'nullable|string',
        ], [
            'amount_paid.required' => 'The pay amount field is required.',
        ]);

        $purchase = DB::table('purchases')->where('id', $request->purchase_id)->first();

        if (!$purchase) {
            return redirect()->back()->with('error', 'Purchase not found!');
        }

        $totalPaid = DB::table('payments')
            ->where('purchase_id', $purchase->id)
            ->sum('amount_paid');

        $remaining = $purchase->total_amount - $totalPaid;

        if ($remaining <= 0) {
            return redirect()->back()->with('error', 'This purchase is already fully paid. No further payments allowed!');
        }

        $payAmount = min($request->amount_paid, $remaining);

        $due = $remaining - $payAmount;

        if ($due <= 0) {
            $status = 'paid';
            $due = 0;
        } elseif ($due < $purchase->total_amount) {
            $status = 'due';
        } else {
            $status = 'unpaid';
        }

        // Start Transaction for data safety
        DB::beginTransaction();

        try {
            // Insert payment record
            DB::table('payments')->insert([
                'purchase_id'    => $purchase->id,
                'party_id'       => $request->party_id,
                'amount_paid'    => $payAmount,
                'due_amount'     => $due,
                'total_amount'   => $purchase->total_amount,
                'payment_status' => $status,
                'payment_mode'   => $request->payment_mode,
                'payment_date'   => $request->payment_date,
                'financial_year' => session('financial_year')['name'] ?? null,
                'remarks'        => $request->remarks,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // Update purchase status
            DB::table('purchases')
                ->where('id', $purchase->id)
                ->update([
                    'payment_status' => $status,
                    'updated_at'     => now(),
                ]);

            // Deduct from account_balances table
            $accountBalance = DB::table('account_balances')->first();

            if ($accountBalance) {
                $newBalance = $accountBalance->amount - $payAmount;

                if ($newBalance < 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Insufficient balance in account!');
                }

                DB::table('account_balances')
                    ->where('id', $accountBalance->id)
                    ->update([
                        'amount' => $newBalance,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Account balance record not found!');
            }

            DB::commit();
            return redirect()->route('admin.purchase.list')->with('success', 'Payment successfully recorded and account balance updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error while recording payment: ' . $e->getMessage());
        }
    }

    // Payment LIst
    public function paymentList(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table('payments')
                ->join('purchases', 'payments.purchase_id', '=', 'purchases.id')
                ->join('account', 'payments.party_id', '=', 'account.id')
                ->join('products', 'purchases.product_id', '=', 'products.id')
                ->whereNull('payments.deleted_at')
                ->select(
                    'payments.*',
                    'purchases.bill_no',
                    'products.product_name',
                    'account.party_name',
                )
                ->orderBy('payments.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.payment.list');
    }

    public function paymentFilter()
    {
        $accountData = AccountModel::orderBy('id', 'desc')->get();
        return view('admin.pages.payment.filter-data-list', compact('accountData'));
    }

    public function getPaymentFilter(Request $request)
    {
        $request->validate([
            'party_id'  => 'required',
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ], [
            'party_id.required'  => 'Please select a party.',
            'from_date.required' => 'Please select from date.',
            'to_date.required'   => 'Please select to date.',
        ]);

        // Fetch filtered payment data with join
        $paymentDetails = DB::table('payments')
            ->join('account', 'payments.party_id', '=', 'account.id')
            ->join('purchases', 'payments.purchase_id', '=', 'purchases.id')
            ->select(
                'payments.*',
                'account.party_name',
                'account.contact_person',
                'account.mobile_number',
                'purchases.bill_no',
                'purchases.total_amount as purchase_total'
            )
            ->where('payments.party_id', $request->party_id)
            ->whereBetween('payments.payment_date', [$request->from_date, $request->to_date])
            ->orderBy('payments.payment_date', 'asc')
            ->get();

        $accountData = AccountModel::orderBy('id', 'desc')->get();

        return view('admin.pages.payment.filter-data-list', [
            'accountData'       => $accountData,
            'paymentDetails'    => $paymentDetails,
            'selectedPartyId'   => $request->party_id,
            'selectedFromDate'  => $request->from_date,
            'selectedToDate'    => $request->to_date,
        ]);
    }
}
