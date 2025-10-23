<?php

namespace App\Http\Controllers\BricksSale;

use App\Http\Controllers\Controller;
use App\Models\AccountBalances\AccountBalancesModel;
use App\Models\BricksSale\BricksSaleModel;
use App\Models\BricksStock\BricksStockModel;
use App\Models\BricksStockTransaction\BricksStockTransactionModel;
use App\Models\vehicle\VehicleModel;
use App\Models\BricksTypeCategory\BricksTypeCategoryModel;
use App\Models\BricksTypeSubCategory\BricksTypeSubCategoryModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BricksSaleController extends Controller
{
    public function createBricksSaleView()
    {
        $vehicles = VehicleModel::orderBy('id', 'desc')->get();
        $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
        $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();
        return view('admin.pages.bricks-sale.create', compact('category', 'subCategory', 'vehicles'));
    }

    public function storeBricksSale(Request $request)
    {
        $request->validate([
            'bill_no'                     => 'unique:bricks_sales,bill_no',
            'vehicle_id'                  => 'required|numeric',
            'bricks_type_category_id'     => 'required|numeric',
            'bricks_type_sub_category_id' => 'nullable|string|max:100',
            'customer_name'               => 'required|string|max:100',
            'customer_mobile'             => 'nullable|digits_between:10,15',
            'customer_address'            => 'required|string|max:255',
            'customer_city'               => 'nullable|string|max:50',
            'customer_state'              => 'nullable|string|max:50',
            'quantity'                    => 'required|numeric|min:1',
            'rate_per_thousand'           => 'required|numeric',
            'total_amount'                => 'required|numeric',
            'amount_received'             => 'required|numeric',
            'due_amount'                  => 'nullable|numeric',
            'payment_mode'                => 'nullable|string|max:50',
            'sale_date'                   => 'required|date',
            'upload_image'                => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'remarks'                     => 'nullable|string|max:255',
        ], [
            'bill_no.unique'                    => 'This bill number already exists, please try again.',
            'vehicle_id.required'               => 'The vehicle field is required.',
            'bricks_type_category_id.required'  => 'The bricks category field is required.',
            'customer_mobile.digits_between'    => 'Mobile number must be between 10 and 15 digits.',
            'upload_image.file'                 => 'The image must be a valid file.',
            'upload_image.mimes'                => 'The image must be a jpeg, png, jpg, or webp.',
            'upload_image.max'                  => 'The image size must not exceed 10MB.',
        ]);

        DB::beginTransaction();

        try {
            $sale = new BricksSaleModel();

            // Generate Bill Number
            do {
                $year = date('Y');
                $lastSale = BricksSaleModel::whereYear('created_at', $year)->latest()->first();

                if ($lastSale && isset($lastSale->bill_no)) {
                    $lastSerial = (int) explode('-', $lastSale->bill_no)[1];
                    $serial = str_pad($lastSerial + 1, 3, '0', STR_PAD_LEFT);
                } else {
                    $serial = '001';
                }

                $bill_no = $year . '-' . $serial;
            } while (BricksSaleModel::where('bill_no', $bill_no)->exists());

            // Fill Sale Details
            $sale->bill_no                     = $bill_no;
            $sale->vehicle_id                  = $request->vehicle_id;
            $sale->bricks_type_category_id     = $request->bricks_type_category_id;
            $sale->bricks_type_sub_category_id = $request->bricks_type_sub_category_id;
            $sale->customer_name               = $request->customer_name;
            $sale->customer_mobile             = $request->customer_mobile;
            $sale->customer_address            = $request->customer_address;
            $sale->customer_city               = $request->customer_city;
            $sale->customer_state              = $request->customer_state;
            $sale->quantity                    = $request->quantity;
            $sale->rate_per_thousand           = $request->rate_per_thousand;
            $sale->total_amount                = $request->total_amount;
            $sale->amount_received             = $request->amount_received;
            $sale->due_amount                  = $request->due_amount;
            $sale->payment_mode                = $request->payment_mode;
            $sale->sale_date                   = $request->sale_date;
            $sale->remarks                     = $request->remarks;
            $sale->financial_year              = session('financial_year')['name'] ?? null;

            // Upload Image
            if ($request->hasFile('upload_image')) {
                $file = $request->file('upload_image');
                $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/bricks-sale'), $filename);
                $sale->upload_image = $filename;
            } else {
                $sale->upload_image = 'no-image.png';
            }

            $sale->save();

            // Update Account Balance
            if ($request->filled('amount_received')) {
                $accountBalance = AccountBalancesModel::first();
                if (!$accountBalance) {
                    $accountBalance = new AccountBalancesModel();
                    $accountBalance->amount = 0;
                }

                $accountBalance->amount += $request->amount_received;
                $accountBalance->save();
            }

            // Deduct Bricks from Stock (bricks_stocks table)
            $stockQuery = BricksStockModel::where('bricks_type_category_id', $request->bricks_type_category_id);

            if ($request->bricks_type_sub_category_id) {
                $stockQuery->where('bricks_type_sub_category_id', $request->bricks_type_sub_category_id);
            } else {
                $stockQuery->whereNull('bricks_type_sub_category_id');
            }

            $stock = $stockQuery->first();

            if (!$stock || $stock->bricks_quantity < $request->quantity) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Insufficient stock for this bricks sale.');
            }

            $stock->bricks_quantity -= $request->quantity;
            $stock->save();

            DB::commit();

            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('success', 'Bricks Sale Created Successfully, Stock Updated, and Account Balance Updated. Bill No: ' . $sale->bill_no);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function bricksSaleList(Request $request)
    {
        if ($request->ajax()) {
            $list = BricksSaleModel::select(
                'bricks_sales.id',
                'bricks_sales.bill_no',
                'bricks_sales.customer_name',
                'bricks_sales.customer_mobile',
                'bricks_sales.customer_address',
                'bricks_sales.quantity',
                'bricks_type_categorys.bricks_type_category_name as category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name as sub_category_name'
            )
                ->leftJoin('bricks_type_categorys', 'bricks_sales.bricks_type_category_id', '=', 'bricks_type_categorys.id')
                ->leftJoin('bricks_type_sub_categorys', 'bricks_sales.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
                ->orderBy('bricks_sales.id', 'desc')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $detailsRoute = route('admin.bricks_sale.bricksSaleDetails', Crypt::encrypt($row->id));
                    $receiptRoute = route('admin.bricks_sale.receiptBricksSale', Crypt::encrypt($row->id));
                    $editRoute = route('admin.bricks_sale.editBricksSale', Crypt::encrypt($row->id));
                    $paidDueAmountRoute = route('admin.bricks_sale.paidDueAmount', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.bricks_sale.deleteBricksSale', Crypt::encrypt($row->id));
                    $csrf = csrf_token();

                    return '<div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                        <li>
                            <a class="dropdown-item" href="' . $detailsRoute . '">
                                <i class="fas fa-eye"></i> Details
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="' . $receiptRoute . '">
                                <i class="fas fa-receipt"></i> Receipt
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="' . $editRoute . '">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="' . $paidDueAmountRoute . '">
                                <i class="fa fa-inr"></i> Paid Due Amount
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="' . $csrf . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure want to delete this sale?\')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.pages.bricks-sale.list');
    }

    public function edit_bricks_sale($id)
    {
        try {
            $dataId = Crypt::decrypt($id);
            $getData = DB::table('bricks_sales as bs')
                ->leftJoin('bricks_type_categorys as btc', 'bs.bricks_type_category_id', '=', 'btc.id')
                ->leftJoin('bricks_type_sub_categorys as btsc', 'bs.bricks_type_sub_category_id', '=', 'btsc.id')
                ->leftJoin('vehicles as v', 'bs.vehicle_id', '=', 'v.id')
                ->select(
                    'bs.*',
                    'btc.bricks_type_category_name',
                    'btsc.bricks_type_sub_category_name',
                    'v.vehicle_number',
                    'v.vehicle_type'
                )
                ->where('bs.id', $dataId)
                ->first();

            if (!$getData) {
                return redirect()->route('admin.bricks_sale.bricksSaleList')
                    ->with('error', 'Data not found');
            }

            $vehicles = VehicleModel::orderBy('id', 'desc')->get();
            $category = BricksTypeCategoryModel::get();
            $subCategory = BricksTypeSubCategoryModel::get();

            return view('admin.pages.bricks-sale.edit', compact('getData', 'vehicles', 'category', 'subCategory'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Invalid Data ID');
        }
    }

    public function update_bricks_sale($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_id'                  => 'required|numeric',
                'bricks_type_category_id'     => 'required|numeric',
                'bricks_type_sub_category_id' => 'nullable|string|max:100',
                'customer_name'               => 'required|string|max:100',
                'customer_mobile'             => 'nullable|digits_between:10,15',
                'customer_address'            => 'required|string|max:255',
                'customer_city'               => 'nullable|string|max:50',
                'customer_state'              => 'nullable|string|max:50',
                'sale_date'                   => 'required|date',
                'upload_image'                => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
                'remarks'                     => 'nullable|string|max:255',
            ], [
                'vehicle_id.required'               => 'The vehicle field is required.',
                'bricks_type_category_id.required'  => 'The bricks category field is required.',
                'customer_mobile.digits_between'    => 'Mobile number must be between 10 and 15 digits.',
                'upload_image.file'                 => 'The image must be a valid file.',
                'upload_image.mimes'                => 'The image must be a jpeg, png, jpg, or webp.',
                'upload_image.max'                  => 'The image size must not exceed 10MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $uid = Crypt::decrypt($id);
            $row = BricksSaleModel::findOrFail($uid);
            $row->vehicle_id                  = $request->vehicle_id;
            $row->bricks_type_category_id     = $request->bricks_type_category_id;
            $row->bricks_type_sub_category_id = $request->bricks_type_sub_category_id;
            $row->customer_name               = $request->customer_name;
            $row->customer_mobile             = $request->customer_mobile;
            $row->customer_address            = $request->customer_address;
            $row->customer_city               = $request->customer_city;
            $row->customer_state              = $request->customer_state;
            $row->sale_date                   = $request->sale_date;
            $row->remarks                     = $request->remarks;

            if ($request->upload_image != "") {
                File::delete(public_path('upload/bricks-sale/' . $row->upload_image));
                $image = $request->upload_image;
                $randomStr = Str::random(30);
                $ext = $image->getClientOriginalExtension();
                $imageName = $randomStr . '.' . $ext;
                $image->move(public_path('upload/bricks-sale'), $imageName);
                $row->upload_image = $imageName;
            }

            $row->save();

            return redirect()->route('admin.bricks_sale.bricksSaleList')->with('success', 'Data successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function bricks_sale_details($id)
    {
        try {
            $dataId = Crypt::decrypt($id);
            $getData = DB::table('bricks_sales as bs')
                ->leftJoin('bricks_type_categorys as btc', 'bs.bricks_type_category_id', '=', 'btc.id')
                ->leftJoin('bricks_type_sub_categorys as btsc', 'bs.bricks_type_sub_category_id', '=', 'btsc.id')
                ->leftJoin('vehicles as v', 'bs.vehicle_id', '=', 'v.id')
                ->select(
                    'bs.*',
                    'btc.bricks_type_category_name',
                    'btsc.bricks_type_sub_category_name',
                    'v.vehicle_number',
                    'v.vehicle_type'
                )
                ->where('bs.id', $dataId)
                ->first();

            if (!$getData) {
                return redirect()->route('admin.bricks_sale.bricksSaleList')
                    ->with('error', 'Data not found');
            }

            $vehicles = VehicleModel::orderBy('id', 'desc')->get();
            $category = BricksTypeCategoryModel::get();
            $subCategory = BricksTypeSubCategoryModel::get();

            return view('admin.pages.bricks-sale.details', compact('getData', 'vehicles', 'category', 'subCategory'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Invalid Data ID');
        }
    }

    public function paid_due_amount($id)
    {
        try {
            $dataId = Crypt::decrypt($id);
            $getData = BricksSaleModel::findOrFail($dataId);
            if (!$getData) {
                return redirect()->route('admin.bricks_sale.bricksSaleList')
                    ->with('error', 'Data not found');
            }
            return view('admin.pages.bricks-sale.paid-due-amount', compact('getData'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Invalid Data ID');
        }
    }

    public function update_due_amount(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $dataId = Crypt::decrypt($id);
            $sale = BricksSaleModel::findOrFail($dataId);

            $request->validate([
                'amount_received' => "required|numeric|min:0|max:{$sale->due_amount}",
                'sale_date'   => 'required|date',
            ], [
                'amount_received.max' => 'Paid amount cannot be more than remaining due.',
            ]);

            $sale->amount_received += $request->amount_received;
            $sale->due_amount = $sale->total_amount - $sale->amount_received;
            $sale->sale_date = $request->sale_date;
            $sale->save();

            $accountBalance = AccountBalancesModel::first();
            if (!$accountBalance) {
                $accountBalance = new AccountBalancesModel();
                $accountBalance->amount = 0;
            }

            $accountBalance->amount += $request->paid_amount;
            $accountBalance->save();

            DB::commit();

            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('success', 'Due payment updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function delete_bricks_sale($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $getData = BricksSaleModel::findOrFail($id);

            if ($getData->paid_amount > 0) {
                $account = AccountBalancesModel::first();
                if ($account) {
                    $account->amount -= $getData->paid_amount;
                    $account->save();
                }
            }

            if ($getData->upload_image) {
                File::delete(public_path('upload/bricks-sale/' . $getData->upload_image));
            }

            $getData->delete();

            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('success', 'Sale deleted successfully and amount deducted from account balance.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function receipt_bricks_sale($id)
    {
        try {
            $dataId = Crypt::decrypt($id);

            $sale = DB::table('bricks_sales as bs')
                ->leftJoin('bricks_type_categorys as btc', 'bs.bricks_type_category_id', '=', 'btc.id')
                ->leftJoin('bricks_type_sub_categorys as btsc', 'bs.bricks_type_sub_category_id', '=', 'btsc.id')
                ->leftJoin('vehicles as v', 'bs.vehicle_id', '=', 'v.id')
                ->select(
                    'bs.*',
                    'btc.bricks_type_category_name',
                    'btsc.bricks_type_sub_category_name',
                    'v.vehicle_number',
                    'v.vehicle_type'
                )
                ->where('bs.id', $dataId)
                ->first();

            if (!$sale) {
                return redirect()->route('admin.bricks_sale.bricksSaleList')
                    ->with('error', 'Data not found');
            }

            $companyDetails = DB::table('company_details')->first();

            return view('admin.pages.bricks-sale.receipt', compact('sale', 'companyDetails'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_sale.bricksSaleList')
                ->with('error', 'Invalid Data ID');
        }
    }

    public function bricks_sale_filter()
    {
        return view('admin.pages.bricks-sale.filtar-data-list');
    }

    public function get_bricks_sale_filter(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ], [
            'from_date.date'           => 'The from date must be a valid date.',
            'to_date.date'             => 'The to date must be a valid date.',
            'to_date.after_or_equal'   => 'The to date must be on or after the from date.',
        ]);

        $details = DB::table('bricks_sales')
            ->leftJoin('bricks_type_categorys', 'bricks_sales.bricks_type_category_id', '=', 'bricks_type_categorys.id')
            ->leftJoin('bricks_type_sub_categorys', 'bricks_sales.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
            ->leftJoin('vehicles', 'bricks_sales.vehicle_id', '=', 'vehicles.id')
            ->select(
                'bricks_sales.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name',
                'vehicles.vehicle_number',
                'vehicles.vehicle_type'
            )
            ->whereNull('bricks_sales.deleted_at')
            ->whereBetween('bricks_sales.sale_date', [$request->from_date, $request->to_date])
            ->orderBy('bricks_sales.sale_date', 'asc')
            ->get();

        return view('admin.pages.bricks-sale.filtar-data-list', [
            'details'      => $details,
            'selectedFromDate' => $request->from_date,
            'selectedToDate'   => $request->to_date,
        ]);
    }

    public function vehicle_wise_filter()
    {
        $vehicles = VehicleModel::orderBy('id', 'desc')->get();
        return view('admin.pages.bricks-sale.vehicle-filtar-data-list', compact('vehicles'));
    }

    public function get_vehicle_wise_filter(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|integer',
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
        ], [
            'vehicle_id.required' => 'Please select a vehicle.',
            'from_date.required'  => 'Please select the from date.',
            'to_date.required'    => 'Please select the to date.',
        ]);

        $details = DB::table('bricks_sales')
            ->leftJoin('bricks_type_categorys', 'bricks_sales.bricks_type_category_id', '=', 'bricks_type_categorys.id')
            ->leftJoin('bricks_type_sub_categorys', 'bricks_sales.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
            ->leftJoin('vehicles', 'bricks_sales.vehicle_id', '=', 'vehicles.id')
            ->select(
                'bricks_sales.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name',
                'vehicles.vehicle_number',
                'vehicles.vehicle_type'
            )
            ->whereNull('bricks_sales.deleted_at')
            ->where('bricks_sales.vehicle_id', $request->vehicle_id)
            ->whereBetween('bricks_sales.sale_date', [$request->from_date, $request->to_date])
            ->orderBy('bricks_sales.sale_date', 'asc')
            ->get();

        $vehicles = DB::table('vehicles')->whereNull('deleted_at')->get();

        return view('admin.pages.bricks-sale.vehicle-filtar-data-list', [
            'details' => $details,
            'vehicles' => $vehicles,
            'selectedVehicle' => $request->vehicle_id,
            'selectedFromDate' => $request->from_date,
            'selectedToDate' => $request->to_date,
        ]);
    }

    public function customer_wise_filter()
    {
        $customers = DB::table('bricks_sales')
            ->select('customer_name', 'id')
            ->distinct()
            ->get();

        return view('admin.pages.bricks-sale.customer-filtar-data-list', compact('customers'));
    }

    public function get_customer_wise_filter(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer',
        ], [
            'customer_id.required' => 'Please select a customer.',
        ]);

        $details = DB::table('bricks_sales')
            ->leftJoin('bricks_type_categorys', 'bricks_sales.bricks_type_category_id', '=', 'bricks_type_categorys.id')
            ->leftJoin('bricks_type_sub_categorys', 'bricks_sales.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
            ->leftJoin('vehicles', 'bricks_sales.vehicle_id', '=', 'vehicles.id')
            ->select(
                'bricks_sales.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name',
                'vehicles.vehicle_number',
                'vehicles.vehicle_type'
            )
            ->whereNull('bricks_sales.deleted_at')
            ->where('bricks_sales.id', $request->customer_id)

            ->orderBy('bricks_sales.sale_date', 'asc')
            ->get();

        return view('admin.pages.bricks-sale.customer-filtar-data-list', [
            'details' => $details,
            'customers' => DB::table('bricks_sales')->select('customer_name', 'id')->distinct()->get(),
            'selectedCustomer' => $request->customer_id,
        ]);
    }

    public function bricks_wise_filter()
    {
        $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
        $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();
        return view('admin.pages.bricks-sale.bricks-filtar-data-list', compact('category', 'subCategory'));
    }

    public function get_bricks_wise_filter(Request $request)
    {
        $request->validate([
            'bricks_type_category_id' => 'required|integer',
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ], [
            'bricks_type_category_id.required' => 'Please select a category.',
            'from_date.required' => 'Please select the from date.',
            'to_date.required'   => 'Please select the to date.',
        ]);

        $query = DB::table('bricks_sales')
            ->leftJoin('bricks_type_categorys', 'bricks_sales.bricks_type_category_id', '=', 'bricks_type_categorys.id')
            ->leftJoin('bricks_type_sub_categorys', 'bricks_sales.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
            ->select(
                'bricks_sales.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name'
            )
            ->whereNull('bricks_sales.deleted_at')
            ->where('bricks_sales.bricks_type_category_id', $request->bricks_type_category_id)
            ->whereBetween('bricks_sales.sale_date', [$request->from_date, $request->to_date]);

        if ($request->bricks_type_sub_category_id) {
            $query->where('bricks_sales.bricks_type_sub_category_id', $request->bricks_type_sub_category_id);
        }

        $details = $query->orderBy('bricks_sales.sale_date', 'asc')->get();

        return view('admin.pages.bricks-sale.bricks-filtar-data-list', [
            'details' => $details,
            'category' => BricksTypeCategoryModel::orderBy('id', 'desc')->get(),
            'subCategory' => BricksTypeSubCategoryModel::orderBy('id', 'desc')->get(),
            'selectedCategory' => $request->bricks_type_category_id,
            'selectedSubCategory' => $request->bricks_type_sub_category_id,
            'selectedFromDate' => $request->from_date,
            'selectedToDate' => $request->to_date,
        ]);
    }
}
