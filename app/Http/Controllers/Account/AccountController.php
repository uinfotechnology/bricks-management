<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\AccountModel;
use App\Models\Payment\PaymentModel;
use App\Models\Product\ProductModel;
use App\Models\Purchase\PurchaseModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    public function createView()
    {
        $product = ProductModel::orderBy('id', 'DESC')->get();
        return view('admin.pages.account.create', compact('product'));
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id'              => 'required|string|max:255',
            'party_name'              => 'required|string|max:255',
            'contact_person'          => 'nullable|string|max:255',
            'mobile_number'           => 'required|digits_between:10,15',
            'secondary_mobile_number' => 'nullable|digits_between:10,15',
            'gst_number'              => 'nullable|string|max:15',
            'pan_number'              => 'nullable|string|max:10',
            'opening_balance'         => 'required|min:0',
            'address'                 => 'nullable|string|max:500',
            'bank_name'               => 'nullable|string|max:255',
            'account_number'          => 'nullable|string|max:30',
            'ifsc_code'               => 'nullable|string|max:11',
            'account_holder_name'     => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string|max:500',
            'created_date'            => 'required|date',
        ], [
            'product_id.required' => 'The product type field is required.',
            'mobile_number.digits_between' => 'Mobile number must be between 10 and 15 digits.',
            'secondary_mobile_number.digits_between' => 'Secondary mobile number must be between 10 and 15 digits.',


        ]);

        AccountModel::create([
            'product_id'              => $request->product_id,
            'party_name'              => $request->party_name,
            'contact_person'          => $request->contact_person,
            'mobile_number'           => $request->mobile_number,
            'secondary_mobile_number' => $request->secondary_mobile_number,
            'gst_number'              => $request->gst_number,
            'pan_number'              => $request->pan_number,
            'opening_balance'         => $request->opening_balance,
            'address'                 => $request->address,
            'bank_name'               => $request->bank_name,
            'account_number'          => $request->account_number,
            'ifsc_code'               => $request->ifsc_code,
            'account_holder_name'     => $request->account_holder_name,
            'financial_year'          => session('financial_year')['name'] ?? null,
            'remarks'                 => $request->remarks,
            'date'                    => $request->created_date,
        ]);

        return redirect()->back()->with('success', 'New Account has been created');
    }

    public function accountList(Request $request)
    {
        if ($request->ajax()) {
            $list = AccountModel::select('account.*', 'products.product_name')
                ->leftJoin('products', 'account.product_id', '=', 'products.id')
                ->orderBy('account.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $paymentDetailsRoute = route('admin.account.accountPaymentDetails', Crypt::encrypt($row->id));
                    $detailsRoute = route('admin.account.accountDetails', Crypt::encrypt($row->id));
                    $editRoute = route('admin.account.editAccount', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.account.deleteAccount', Crypt::encrypt($row->id));
                    return '<div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false"> Actions</button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                            <li><a class="dropdown-item" href="' . $paymentDetailsRoute . '"><i class="fa-solid fa-inr"></i> Payment Details</a></li>
                            <li><a class="dropdown-item" href="' . $detailsRoute . '"><i class="fa-solid fa-list"></i> Details</a></li>
                            <li><a class="dropdown-item" href="' . $editRoute . '"><i class="fas fa-edit"></i> Edit</a></li>
                            <li><a class="dropdown-item delete-account" href="javascript:void(0)" data-url="' . $deleteRoute . '"><i class="fas fa-trash"></i> Delete</a></li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.account.list');
    }

    public function editAccount($id)
    {
        try {
            $accountId = Crypt::decrypt($id);
            $account = AccountModel::findOrFail($accountId);

            $product = ProductModel::orderBy('id', 'DESC')->get();

            return view('admin.pages.account.edit', compact('account', 'product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.account.createView')
                ->with('error', 'Invalid Account ID');
        }
    }

    public function updateAccount(Request $request, $id)
    {
        $accountId = Crypt::decrypt($id);
        $account = AccountModel::findOrFail($accountId);

        $request->validate([
            'product_id'              => 'required|string|max:255',
            'party_name'              => 'required|string|max:255',
            'contact_person'          => 'nullable|string|max:255',
            'mobile_number'           => 'required|digits_between:10,15',
            'secondary_mobile_number' => 'nullable|digits_between:10,15',
            'gst_number'              => 'nullable|string|max:15',
            'pan_number'              => 'nullable|string|max:10',
            'opening_balance'         => 'required|min:0',
            'address'                 => 'nullable|string|max:500',
            'bank_name'               => 'nullable|string|max:255',
            'account_number'          => 'nullable|string|max:30',
            'ifsc_code'               => 'nullable|string|max:11',
            'account_holder_name'     => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string|max:500',
            'date'                    => 'required|date',
        ], [
            'product_id.required' => 'The product type field is required.',
            'mobile_number.digits_between' => 'Mobile number must be between 10 and 15 digits.',
            'secondary_mobile_number.digits_between' => 'Secondary mobile number must be between 10 and 15 digits.',
        ]);

        $account->update([
            'product_id'              => $request->product_id,
            'party_name'              => $request->party_name,
            'contact_person'          => $request->contact_person,
            'mobile_number'           => $request->mobile_number,
            'secondary_mobile_number' => $request->secondary_mobile_number,
            'gst_number'              => $request->gst_number,
            'pan_number'              => $request->pan_number,
            'opening_balance'         => $request->opening_balance,
            'address'                 => $request->address,
            'bank_name'               => $request->bank_name,
            'account_number'          => $request->account_number,
            'ifsc_code'               => $request->ifsc_code,
            'account_holder_name'     => $request->account_holder_name,
            'remarks'                 => $request->remarks,
            'date'                    => $request->date,
        ]);

        return redirect()->route('admin.account.list')
            ->with('success', 'Account Updated Successfully');
    }

    public function deleteAccount($id)
    {
        try {
            $accountId = Crypt::decrypt($id);
            $account = AccountModel::findOrFail($accountId);

            $account->delete();

            return response()->json([
                'status' => true,
                'message' => 'Account deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function accountDetails($id)
    {
        try {
            $accountId = Crypt::decrypt($id);
            $accountDetails = AccountModel::select('account.*', 'products.product_name')
                ->leftJoin('products', 'products.id', '=', 'account.product_id')
                ->where('account.id', $accountId)
                ->first();

            return view('admin.pages.account.details', compact('accountDetails'));
        } catch (\Exception $e) {
            return redirect()->route('admin.account.list')
                ->with('error', 'Invalid Account ID');
        }
    }

    public function accountPaymentDetails($id)
    {
        try {
            // डिक्रिप्ट ID
            $accountId = Crypt::decrypt($id);

            // अकाउंट डिटेल्स लें
            $accountDetails = AccountModel::select('account.*', 'products.product_name')
                ->leftJoin('products', 'products.id', '=', 'account.product_id')
                ->where('account.id', $accountId)
                ->first();

            if (!$accountDetails) {
                Log::error('Account details not found for ID: ' . $accountId);
                throw new \Exception('Account details not found.');
            }

            // परचेज़ डेटा लें (product_id की कंडीशन हटाई गई)
            $purchases = PurchaseModel::select('purchases.*', 'products.product_name')
                ->leftJoin('products', 'products.id', '=', 'purchases.product_id')
                ->where('purchases.party_id', $accountId)
                ->get();

            if ($purchases->isEmpty()) {
                Log::warning('No purchases found for party_id: ' . $accountId);
            }

            // पेमेंट डेटा लें
            $purchaseIds = $purchases->pluck('id')->toArray();
            $payments = PaymentModel::whereIn('purchase_id', $purchaseIds)->get();

            if ($payments->isEmpty() && !empty($purchaseIds)) {
                Log::warning('No payments found for purchase IDs: ' . implode(', ', $purchaseIds));
            }

            return view('admin.pages.account.payment-details', compact('accountDetails', 'purchases', 'payments'));
        } catch (\Exception $e) {
            Log::error('Error in accountPaymentDetails: ' . $e->getMessage());
            return redirect()->route('admin.account.list')
                ->with('error', 'Invalid Account ID or No Details Found: ' . $e->getMessage());
        }
    }
}
