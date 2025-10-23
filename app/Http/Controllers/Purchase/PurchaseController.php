<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Account\AccountModel;
use App\Models\Product\ProductModel;
use App\Models\Purchase\PurchaseModel;
use App\Models\stock\StockModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;

class PurchaseController extends Controller
{
    public function purchaseView()
    {
        $product = ProductModel::orderBy('id', 'DESC')->get();
        $party = AccountModel::orderBy('id', 'DESC')->get();
        return view('admin.pages.purchase.create', compact('product', 'party'));
    }

    public function storePurchase(Request $request)
    {
        $request->validate([
            'bill_no'       => 'required|string|max:255|unique:purchases,bill_no',
            'product_id'    => 'required|string|max:255',
            'party_id'      => 'required|integer|exists:account,id',
            'rate'          => 'required|numeric|min:0',
            'quantity'      => 'required|numeric|min:1',
            'unit'          => 'required|string|max:100',
            'discount'      => 'required|numeric|min:0',
            'gst'           => 'required|numeric|min:0',
            'total_amount'  => 'required|numeric|min:0',
            'date'          => 'required|date',
        ], [
            'party_id.required' => 'The party field is required.',
            'bill_no.unique'    => 'This bill number already exists.',
        ]);

        $purchase = new PurchaseModel();
        $purchase->bill_no      = $request->bill_no;
        $purchase->product_id   = $request->product_id;
        $purchase->party_id     = $request->party_id;
        $purchase->rate         = $request->rate;
        $purchase->quantity     = $request->quantity;
        $purchase->unit         = $request->unit;
        $purchase->discount     = $request->discount ?? 0;
        $purchase->gst          = $request->gst ?? 0;
        $purchase->total_amount = $request->total_amount;
        $purchase->financial_year = session('financial_year')['name'] ?? null;
        $purchase->date         = $request->date;
        $purchase->save();

        // Stock Update/Create
        $stock = StockModel::where('product_id', $request->product_id)->first();

        if ($stock) {
            // Convert incoming purchase quantity to stock unit (kg)
            $convertedQuantity = $request->quantity;
            if ($request->unit == 'quintal') {
                $convertedQuantity *= 100;
            } elseif ($request->unit == 'ton') {
                $convertedQuantity *= 1000;
            }

            $stock->quantity += $convertedQuantity;
            $stock->total_amount += $request->total_amount;
            $stock->save();
        } else {
            $convertedQuantity = $request->quantity;
            if ($request->unit == 'quintal') {
                $convertedQuantity *= 100;
            } elseif ($request->unit == 'ton') {
                $convertedQuantity *= 1000;
            }

            StockModel::create([
                'product_id'   => $request->product_id,
                'quantity'     => $convertedQuantity,
                'total_amount' => $request->total_amount,
                'unit'         => 'kilogram',
            ]);
        }


        // Stock Transaction Insert
        DB::table('stock_transactions')->insert([
            'product_id'        => $purchase->product_id,
            'purchase_id'       => $purchase->id,
            'party_id'          => $purchase->party_id,
            'quantity'          => $purchase->quantity,
            'unit'              => $purchase->unit,
            'rate'              => $purchase->rate,
            'gst'               => $purchase->gst,
            'total_amount'      => $purchase->total_amount,
            'transaction_type'  => 'Purchase',
            'financial_year'    => session('financial_year')['name'] ?? null,
            'date'              => $purchase->date,
            'remarks'           => 'Purchase Bill No: ' . $purchase->bill_no,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('admin.purchase.list')->with('success', 'Purchase, Stock Updated Successfully');
    }

    public function purchaseList(Request $request)
    {
        if ($request->ajax()) {
            $list = PurchaseModel::select('purchases.*', 'account.party_name', 'products.product_name')
                ->leftJoin('account', 'purchases.party_id', '=', 'account.id')
                ->leftJoin('products', 'purchases.product_id', '=', 'products.id')
                ->orderBy('purchases.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $paymentReceipt = route('admin.purchase.paymentReceipt', Crypt::encrypt($row->id));
                    $paymentRoute = route('admin.payment.createPayment', Crypt::encrypt($row->id));
                    $editRoute = route('admin.purchase.editPurchase', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.purchase.deletePurchase', Crypt::encrypt($row->id));

                    // Payment button logic
                    if ($row->payment_status === 'paid') {
                        $paymentButton = '<li><a class="dropdown-item disabled" href="javascript:void(0)"><i class="fa-solid fa-share-from-square"></i> Payment Paid</a></li>';
                    } else {
                        $paymentButton = '<li><a class="dropdown-item" href="' . $paymentRoute . '"><i class="fa-solid fa-share-from-square"></i> Payment</a></li>';
                    }

                    return '
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false"> Actions</button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                            <li><a class="dropdown-item" href="' . $paymentReceipt . '"><i class="fa-solid fa-receipt"></i> Receipt</a></li>
                            ' . $paymentButton . '
                            <li><a class="dropdown-item" href="' . $editRoute . '"><i class="fas fa-edit"></i> Edit</a></li>
                            <li><a class="dropdown-item delete-account" href="javascript:void(0)" data-url="' . $deleteRoute . '"><i class="fas fa-trash"></i> Delete</a></li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.purchase.list');
    }

    public function editPurchase($id)
    {
        try {
            $purchaseId = Crypt::decrypt($id);
            $purchase = PurchaseModel::findOrFail($purchaseId);
            $currentYear = DB::table('financial_years')->where('is_active', 1)->first();
            $product = ProductModel::orderBy('id', 'DESC')->get();
            $party = AccountModel::orderBy('id', 'DESC')->get();

            return view('admin.pages.purchase.edit', compact('purchase', 'product', 'currentYear', 'party'));
        } catch (\Exception $e) {
            return redirect()->route('admin.purchase.list')
                ->with('error', 'Invalid Purchase Details ID');
        }
    }

    public function updatePurchase(Request $request, $id)
    {
        $purchaseId = Crypt::decrypt($id);
        $purchase = PurchaseModel::findOrFail($purchaseId);

        $request->validate([
            'bill_no'       => 'required|string|max:255|unique:purchases,bill_no,' . $purchase->id,
            'product_id'    => 'required|string|max:255',
            'party_id'      => 'required|integer|exists:account,id',
            'rate'          => 'required|numeric|min:0',
            'quantity'      => 'required|numeric|min:1',
            'unit'          => 'required|string|max:100',
            'discount'      => 'required|numeric|min:0',
            'gst'           => 'required|numeric|min:0',
            'total_amount'  => 'required|numeric|min:0',
            'date'          => 'required|date',
        ], [
            'party_id.required' => 'The party field is required.',
            'bill_no.unique'    => 'This bill number already exists.',
        ]);

        // ----------------------------
        // OLD PURCHASE DATA
        // ----------------------------
        $oldQuantity    = $purchase->quantity;
        $oldUnit        = $purchase->unit;
        $oldTotalAmount = $purchase->total_amount;
        $oldProductId   = $purchase->product_id;

        $oldConvertedQuantity = $oldQuantity;
        if ($oldUnit == 'quintal') {
            $oldConvertedQuantity *= 100;
        } elseif ($oldUnit == 'ton') {
            $oldConvertedQuantity *= 1000;
        }

        // ----------------------------
        // NEW PURCHASE UPDATE
        // ----------------------------
        $purchase->bill_no           = $request->bill_no;
        $purchase->product_id        = $request->product_id;
        $purchase->party_id          = $request->party_id;
        $purchase->rate              = $request->rate;
        $purchase->quantity          = $request->quantity;
        $purchase->unit              = $request->unit;
        $purchase->discount          = $request->discount ?? 0;
        $purchase->gst               = $request->gst ?? 0;
        $purchase->total_amount      = $request->total_amount;
        $purchase->date              = $request->date;
        $purchase->save();

        $newConvertedQuantity = $request->quantity;
        if ($request->unit == 'quintal') {
            $newConvertedQuantity *= 100;
        } elseif ($request->unit == 'ton') {
            $newConvertedQuantity *= 1000;
        }

        // ----------------------------
        // STOCK UPDATE
        // ----------------------------

        $oldStock = StockModel::where('product_id', $oldProductId)->first();
        if ($oldStock) {
            $oldStock->quantity     -= $oldConvertedQuantity;
            $oldStock->total_amount -= $oldTotalAmount;
            $oldStock->save();
        }

        $newStock = StockModel::firstOrCreate(
            ['product_id' => $purchase->product_id],
            ['quantity'   => 0, 'total_amount' => 0, 'unit' => 'kilogram']
        );
        $newStock->quantity     += $newConvertedQuantity;
        $newStock->total_amount += $purchase->total_amount;
        $newStock->save();

        // ----------------------------
        // STOCK TRANSACTION UPDATE
        // ----------------------------
        DB::table('stock_transactions')->where('purchase_id', $purchase->id)->update([
            'product_id'   => $purchase->product_id,
            'party_id'     => $purchase->party_id,
            'quantity'     => $purchase->quantity,
            'unit'         => $purchase->unit,
            'rate'         => $purchase->rate,
            'gst'          => $purchase->gst,
            'total_amount' => $purchase->total_amount,
            'date'         => $purchase->date,
            'remarks'      => 'Purchase Bill No: ' . $purchase->bill_no,
            'updated_at'   => now(),
        ]);

        return redirect()->route('admin.purchase.list')
            ->with('success', 'Purchase, Stock Updated Successfully');
    }

    public function deletePurchase($id)
    {
        try {
            $purchaseId = Crypt::decrypt($id);
            $purchase = PurchaseModel::findOrFail($purchaseId);

            // Stock Update: Purchase quantity minus
            $stock = StockModel::where('product_id', $purchase->product_id)->first();
            if ($stock) {
                $stock->quantity     -= $purchase->quantity;
                $stock->total_amount -= $purchase->total_amount;
                $stock->save();
            }

            // Soft Delete Purchase
            $purchase->delete();

            // Soft Delete related Stock Transactions
            DB::table('stock_transactions')
                ->where('purchase_id', $purchase->id)
                ->update(['deleted_at' => now()]);

            // Soft Delete related Payments
            DB::table('payments')
                ->where('purchase_id', $purchase->id)
                ->update(['deleted_at' => now()]);

            return response()->json([
                'status' => true,
                'message' => 'Purchase and related records deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete purchase: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentReceipt($id)
    {
        try {
            // Decrypt the purchase ID
            $purchaseId = Crypt::decrypt($id);

            // Get the purchase along with related data using joins
            $purchase = DB::table('purchases')
                ->join('products', 'purchases.product_id', '=', 'products.id')
                ->join('account', 'purchases.party_id', '=', 'account.id')
                ->leftJoin('payments', 'purchases.id', '=', 'payments.purchase_id')
                ->select(
                    'purchases.id as purchase_id',
                    'purchases.bill_no',
                    'purchases.rate',
                    'purchases.quantity',
                    'purchases.unit',
                    'purchases.discount',
                    'purchases.gst',
                    'purchases.date',
                    'purchases.total_amount as purchase_total',
                    'purchases.payment_status as purchase_payment_status',
                    'products.product_name',
                    'account.party_name',
                    'account.contact_person',
                    'account.mobile_number',
                    DB::raw('IFNULL(SUM(payments.amount_paid),0) as total_paid'),
                    DB::raw('MAX(payments.payment_date) as last_payment_date'),
                    DB::raw('MAX(payments.payment_mode) as last_payment_mode'),
                    DB::raw('MAX(payments.remarks) as last_payment_remarks')
                )
                ->where('purchases.id', $purchaseId)
                ->groupBy(
                    'purchases.id',
                    'purchases.bill_no',
                    'purchases.rate',
                    'purchases.quantity',
                    'purchases.unit',
                    'purchases.discount',
                    'purchases.gst',
                    'purchases.date',
                    'purchases.financial_year',
                    'purchases.total_amount',
                    'purchases.payment_status',
                    'products.product_name',
                    'account.party_name',
                    'account.contact_person',
                    'account.mobile_number',
                )
                ->first();

            $companyDetsils = DB::table('company_details')->first();

            if (!$purchase) {
                return redirect()->route('admin.purchase.list')
                    ->with('error', 'Purchase not found.');
            }

            // Calculate due amount
            $purchase->due_amount = $purchase->purchase_total - $purchase->total_paid;

            return view('admin.pages.purchase.payment-receipt', compact('purchase', 'companyDetsils'));
        } catch (\Exception $e) {
            return redirect()->route('admin.purchase.list')
                ->with('error', 'Invalid Purchase Details ID');
        }
    }

    public function purchaseFilter()
    {
        $getProduct = ProductModel::orderBy('id', 'desc')->get();
        return view('admin.pages.purchase.filter-data-list', compact('getProduct'));
    }

    public function getPurchaseFilter(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
        ], [
            'product_id.required' => 'The product field is required.',
            'from_date.date'      => 'The from date must be a valid date.',
            'to_date.date'        => 'The to date must be a valid date.',
            'to_date.after_or_equal' => 'The to date must be on or after the from date.',
        ]);

        $getProduct = ProductModel::orderBy('id', 'desc')->get();

        $purchaseDetails = DB::table('purchases')
            ->join('products', 'purchases.product_id', '=', 'products.id')
            ->join('account', 'purchases.party_id', '=', 'account.id')
            ->select(
                'purchases.*',
                'products.product_name',
                'account.party_name',
                'account.contact_person',
                'account.mobile_number',
                'account.secondary_mobile_number',
                'account.gst_number',
                'account.pan_number',
                'account.opening_balance',
                'account.address',
                'account.bank_name',
                'account.account_number',
                'account.ifsc_code',
                'account.account_holder_name'
            )
            ->where('purchases.product_id', $request->product_id)
            ->whereBetween('purchases.date', [$request->from_date, $request->to_date])
            ->orderBy('purchases.date', 'asc')
            ->get();

        return view('admin.pages.purchase.filter-data-list', [
            'getProduct'        => $getProduct,
            'purchaseDetails'   => $purchaseDetails,
            'selectedProductId' => $request->product_id,
            'selectedFromDate'  => $request->from_date,
            'selectedToDate'    => $request->to_date,
        ]);
    }
}
