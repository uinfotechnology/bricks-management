<?php

namespace App\Http\Controllers\vehicle;

use App\Http\Controllers\Controller;
use App\Models\vehicle\VehicleModel;
use App\Models\VehiclePayment\VehiclePaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function createVehicleView()
    {
        return view('admin.pages.vehicle.create');
    }

    public function storeVehicle(Request $request)
    {
        $request->validate([
            'vehicle_type'     => 'required|string|max:255',
            'ownar_name'       => 'required|string|max:255',
            'contact_no'       => 'nullable|digits_between:10,15',
            'address'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'state'            => 'nullable|string|max:255',
            'vehicle_name'     => 'required|string|max:255',
            'vehicle_number'   => 'required|string|max:255',
            'aadhar_card'      => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'vehicle_document' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'remarks'          => 'nullable|string|max:255',
        ], [
            'aadhar_card.file'       => 'The image must be a valid file.',
            'aadhar_card.mimes'      => 'The image must be a jpeg, png, jpg, or webp.',
            'aadhar_card.max'        => 'The image size must not exceed 10MB.',
            'vehicle_document.file'  => 'The image must be a valid file.',
            'vehicle_document.mimes' => 'The image must be a jpeg, png, jpg, or webp.',
            'vehicle_document.max'   => 'The image size must not exceed 10MB.',
        ]);

        $vehicle = new VehicleModel();
        $vehicle->vehicle_type   = $request->vehicle_type;
        $vehicle->ownar_name     = $request->ownar_name;
        $vehicle->contact_no     = $request->contact_no;
        $vehicle->address        = $request->address;
        $vehicle->city           = $request->city;
        $vehicle->state          = $request->state;
        $vehicle->vehicle_name   = $request->vehicle_name;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->rent_amount    = $request->rent_amount;
        $vehicle->remarks        = $request->remarks;
        $vehicle->financial_year = session('financial_year')['name'] ?? null;

        if ($request->hasFile('aadhar_card')) {
            $file = $request->file('aadhar_card');
            $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/vehicle'), $filename);
            $vehicle->aadhar_card = $filename;
        } else {
            $vehicle->aadhar_card = 'no-image.png';
        }

        if ($request->hasFile('vehicle_document')) {
            $file = $request->file('vehicle_document');
            $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/vehicle'), $filename);
            $vehicle->vehicle_document = $filename;
        } else {
            $vehicle->vehicle_document = 'no-image.png';
        }

        $vehicle->save();

        return redirect()->route('admin.vehicle.vehicleList')
            ->with('success', 'Vehicle Created Successfully');
    }

    public function vehicleList(Request $request)
    {
        if ($request->ajax()) {
            $list = VehicleModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $detailsRoute = route('admin.vehicle.vehicleDetails', Crypt::encrypt($row->id));
                    $editRoute = route('admin.vehicle.editVehicle', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.vehicle.deleteVehicle', Crypt::encrypt($row->id));
                    $csrf = csrf_token();

                    // Payment option only for 'rent' type vehicles
                    $paymentOption = '';
                    if (strtolower($row->vehicle_type) == 'rent') {
                        $paymentRoute = route('admin.vehicle.vehiclePayment', Crypt::encrypt($row->id));
                        $paymentOption = '<li>
                        <a class="dropdown-item" href="' . $paymentRoute . '">
                            <i class="fa fa-inr"></i> Payment
                        </a>
                    </li>';
                    }

                    return '<div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                        <li>
                            <a class="dropdown-item" href="' . $detailsRoute . '">
                                <i class="fas fa-truck-pickup"></i> Vehicle Details
                            </a>
                        </li>

                        ' . $paymentOption . '
                        
                        <li>
                            <a class="dropdown-item" href="' . $editRoute . '">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteRoute . '" method="POST" style="display: inline-block;">
                                <input type="hidden" name="_token" value="' . $csrf . '">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure want to delete this data?\')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('admin.pages.vehicle.list');
    }

    public function vehicleDetails($id)
    {
        try {
            $vehicleId = Crypt::decrypt($id);
            $vehicle = VehicleModel::findOrFail($vehicleId);
            return view('admin.pages.vehicle.details', compact('vehicle'));
        } catch (\Exception $e) {
            return redirect()->route('admin.vehicle.labourTypeList')
                ->with('error', 'Invalid Vehicle ID');
        }
    }

    public function editVehicle($id)
    {
        try {
            $vehicleId = Crypt::decrypt($id);
            $vehicle = VehicleModel::findOrFail($vehicleId);
            return view('admin.pages.vehicle.edit', compact('vehicle'));
        } catch (\Exception $e) {
            return redirect()->route('admin.vehicle.vehicleList')
                ->with('error', 'Invalid Vehicle ID');
        }
    }

    public function updateVehicle($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_type'     => 'required|string|max:255',
                'ownar_name'       => 'required|string|max:255',
                'contact_no'       => 'nullable|digits_between:10,15',
                'address'          => 'nullable|string|max:255',
                'city'             => 'nullable|string|max:255',
                'state'            => 'nullable|string|max:255',
                'vehicle_name'     => 'required|string|max:255',
                'vehicle_number'   => 'required|string|max:255',
                'aadhar_card'      => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
                'vehicle_document' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
                'remarks'          => 'nullable|string|max:255',
            ], [
                'aadhar_card.file'       => 'The image must be a valid file.',
                'aadhar_card.mimes'      => 'The image must be a jpeg, png, jpg, or webp.',
                'aadhar_card.max'        => 'The image size must not exceed 10MB.',
                'vehicle_document.file'  => 'The image must be a valid file.',
                'vehicle_document.mimes' => 'The image must be a jpeg, png, jpg, or webp.',
                'vehicle_document.max'   => 'The image size must not exceed 10MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $uid = Crypt::decrypt($id);
            $row = VehicleModel::findOrFail($uid);
            $row->vehicle_type   = $request->vehicle_type;
            $row->ownar_name     = $request->ownar_name;
            $row->contact_no     = $request->contact_no;
            $row->address        = $request->address;
            $row->city           = $request->city;
            $row->state          = $request->state;
            $row->vehicle_name   = $request->vehicle_name;
            $row->vehicle_number = $request->vehicle_number;
            $row->rent_amount    = $request->rent_amount;
            $row->remarks        = $request->remarks;

            if ($request->aadhar_card != "") {
                File::delete(public_path('upload/vehicle/' . $row->image));
                $image = $request->aadhar_card;
                $randomStr = Str::random(30);
                $ext = $image->getClientOriginalExtension();
                $imageName = $randomStr . '.' . $ext;
                $image->move(public_path('upload/vehicle'), $imageName);
                $row->aadhar_card = $imageName;
            }

            if ($request->vehicle_document != "") {
                File::delete(public_path('upload/vehicle/' . $row->image));
                $image = $request->vehicle_document;
                $randomStr = Str::random(30);
                $ext = $image->getClientOriginalExtension();
                $imageName = $randomStr . '.' . $ext;
                $image->move(public_path('upload/vehicle'), $imageName);
                $row->vehicle_document = $imageName;
            }

            $row->save();

            return redirect()->route('admin.vehicle.vehicleList')->with('success', 'Vehicle successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function deleteVehicle($id)
    {
        $id = Crypt::decrypt($id);
        $product = VehicleModel::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.vehicle.vehicleList')->with('success', 'Data deleted successfully!');
    }

    public function vehicle_payment($id)
    {
        try {
            $vehicleId = Crypt::decrypt($id);
            $vehicle = VehicleModel::findOrFail($vehicleId);
            return view('admin.pages.vehicle.payment', compact('vehicle'));
        } catch (\Exception $e) {
            return redirect()->route('admin.vehicle.vehicleList')
                ->with('error', 'Invalid Vehicle ID');
        }
    }

    public function store_vehicle_payment($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paid_amount'  => 'required|numeric|max:999999',
                'payment_date' => 'required|date',
                'remarks'      => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $vehicleId = Crypt::decrypt($id);

            DB::beginTransaction();

            $account = DB::table('account_balances')->first();

            if (!$account) {
                return redirect()->back()->with('error', 'Account balance record not found!');
            }

            if ($account->amount < $request->paid_amount) {
                return redirect()->back()->with('error', 'Insufficient account balance!')->withInput();
            }

            $payment = new VehiclePaymentModel();
            $payment->vehicle_id   = $vehicleId;
            $payment->rent_amount  = $request->rent_amount;
            $payment->paid_amount  = $request->paid_amount;
            $payment->payment_date = $request->payment_date;
            $payment->remarks      = $request->remarks;
            $payment->save();

            $newBalance = $account->amount - $request->paid_amount;

            DB::table('account_balances')
                ->where('id', $account->id)
                ->update(['amount' => $newBalance, 'updated_at' => now()]);

            DB::commit();

            return redirect()->route('admin.vehicle.vehicleList')
                ->with('success', 'Vehicle payment successfully done and balance updated.');
        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function vehicle_payment_filter()
    {
        $vehicles = VehicleModel::where('vehicle_type', 'rent')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.pages.vehicle.filtar-data-list', compact('vehicles'));
    }

    public function get_vehicle_payment_filter(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|integer',
            'from_date' => 'required|date',
            'to_date'   => 'required|date|after_or_equal:from_date',
        ]);

        $payments = DB::table('vehicle_payments')
            ->join('vehicles', 'vehicle_payments.vehicle_id', '=', 'vehicles.id')
            ->select('vehicle_payments.*', 'vehicles.vehicle_name', 'vehicles.vehicle_number')
            ->where('vehicle_payments.vehicle_id', $request->vehicle_id)
            ->whereBetween('vehicle_payments.payment_date', [$request->from_date, $request->to_date])
            ->orderBy('vehicle_payments.payment_date', 'asc')
            ->get();

        $vehicles = VehicleModel::where('vehicle_type', 'rent')->orderBy('vehicle_name', 'asc')->get();

        return view('admin.pages.vehicle.filtar-data-list', [
            'vehicles' => $vehicles,
            'payments' => $payments,
            'selectedVehicle' => $request->vehicle_id,
            'selectedFromDate' => $request->from_date,
            'selectedToDate' => $request->to_date,
        ]);
    }
}
