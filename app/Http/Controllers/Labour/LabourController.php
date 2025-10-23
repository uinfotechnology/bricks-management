<?php

namespace App\Http\Controllers\Labour;

use App\Http\Controllers\Controller;
use App\Models\Labour\LabourModel;
use App\Models\LabourType\LabourTypeModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LabourController extends Controller
{
    public function createLabourView()
    {
        $getData = LabourTypeModel::orderBy('id', 'DESC')->get();
        return view('admin.pages.labour.create', compact('getData'));
    }

    public function createLabour(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'labour_type_id'          => 'required',
            'rate_per_thousand'       => 'required|numeric|min:0',
            'name'                    => 'required|string|max:100',
            'mobile_number'           => 'nullable|digits_between:10,15',
            'secondary_mobile_number' => 'nullable|digits_between:10,15',
            'dob'                     => 'nullable|date',
            'gender'                  => 'nullable|string|max:20',
            'aadhar_no'               => 'nullable|digits:12',
            'pan_number'              => 'nullable|string|size:10',
            'city'                    => 'nullable|string|max:50',
            'state'                   => 'nullable|string|max:50',
            'address'                 => 'nullable|string|max:255',
            'upload_image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'remarks'                 => 'nullable|string|max:255',
        ], [
            'labour_type_id.required' => 'The labour type field is required.',
            'mobile_number.digits_between' => 'Primary phone number must be between 10 and 15 digits.',
            'secondary_mobile_number.digits_between' => 'Secondary phone number must be between 10 and 15 digits.',
            'upload_image.file'     => 'The image must be a valid file.',
            'upload_image.mimes'    => 'The image must be a jpeg, png, jpg, or webp.',
            'upload_image.max'      => 'The image size must not exceed 10MB.',
            'aadhar_no.digits'      => 'Aadhar number must be exactly 12 digits.',
            'pan_number.size'       => 'PAN number must be exactly 10 characters.',
        ]);

        $labour = new LabourModel();
        $labour->labour_type_id          = $request->labour_type_id;
        $labour->name                    = $request->name;
        $labour->mobile_number           = $request->mobile_number;
        $labour->secondary_mobile_number = $request->secondary_mobile_number;
        $labour->dob                     = $request->dob;
        $labour->gender                  = $request->gender;
        $labour->aadhar_no               = $request->aadhar_no;
        $labour->pan_number              = $request->pan_number;
        $labour->city                    = $request->city;
        $labour->state                   = $request->state;
        $labour->address                 = $request->address;
        $labour->rate_per_thousand       = $request->rate_per_thousand;
        $labour->financial_year          = session('financial_year')['name'] ?? null;
        $labour->remarks                 = $request->remarks;

        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $filename = Str::random(30) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/labour'), $filename);
            $labour->image = $filename;
        } else {
            $labour->image = 'no-image.png';
        }

        $labour->save();

        return redirect()->route('admin.labour.labourList')
            ->with('success', 'Labour Created Successfully');
    }

    public function labourList(Request $request)
    {
        if ($request->ajax()) {
            $list = LabourModel::select(
                'labours.*',
                'labour_types.labour_type as labour_type_name'
            )
                ->leftJoin('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->orderBy('labours.id', 'desc')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset('upload/labour/' . $row->image) . '" width="50" height="50">';
                    }
                    return '-';
                })
                ->editColumn('labour_type_name', function ($row) {
                    if ($row->labour_type_name) {
                        return ucfirst(str_replace('_', ' ', $row->labour_type_name));
                    }
                    return '-';
                })
                ->editColumn('dob', function ($row) {
                    return $row->dob ? \Carbon\Carbon::parse($row->dob)->format('d-m-Y') : '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y h:i A') : '-';
                })
                ->addColumn('action', function ($row) {
                    $reportSummaryRoute = route('admin.labour.labourReportSummary', Crypt::encrypt($row->id));
                    $detailsRoute = route('admin.labour.labourDetails', Crypt::encrypt($row->id));
                    $workRoute = route('admin.labour.labourWorkDetails', Crypt::encrypt($row->id));
                    $paymentRoute = route('admin.labour.labourPayment', Crypt::encrypt($row->id));
                    $editRoute = route('admin.labour.editLabour', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.labour.deleteLabour', Crypt::encrypt($row->id));
                    $csrf = csrf_token();

                    return '<div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                            <li>
                                <a class="dropdown-item" href="' . $reportSummaryRoute . '">
                                    <i class="far fa-file-alt"></i> Report Summary
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . $detailsRoute . '">
                                    <i class="fas fa-user-alt"></i> Labour Details
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . $workRoute . '">
                                    <i class="fas fa-edit"></i> Work Details
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . $paymentRoute . '">
                                    <i class="fas fa-inr"></i> Payment Details
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . $editRoute . '">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="' . $deleteRoute . '" method="POST" style="display: inline-block;">
                                    <input type="hidden" name="_token" value="' . $csrf . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure want to delete this labour?\')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.pages.labour.list');
    }

    public function editlabour($id)
    {
        try {
            $labourId = Crypt::decrypt($id);
            $labour = LabourModel::findOrFail($labourId);
            $labourType = LabourTypeModel::get();
            return view('admin.pages.labour.edit', compact('labour', 'labourType'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour.labourList')
                ->with('error', 'Invalid Labour ID');
        }
    }

    public function updateLabour($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'labour_type_id'          => 'required',
                'rate_per_thousand'       => 'required|numeric|min:0',
                'name'                    => 'required|string|max:100',
                'mobile_number'           => 'nullable|digits_between:10,15',
                'secondary_mobile_number' => 'nullable|digits_between:10,15',
                'dob'                     => 'nullable|date',
                'gender'                  => 'nullable|string|max:20',
                'aadhar_no'               => 'nullable|digits:12',
                'pan_number'              => 'nullable|string|size:10',
                'city'                    => 'nullable|string|max:50',
                'state'                   => 'nullable|string|max:50',
                'address'                 => 'nullable|string|max:255',
                'upload_image'            => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
                'remarks'                 => 'nullable|string|max:255',
            ], [
                'labour_type_id.required' => 'The labour type field is required.',
                'mobile_number.digits_between' => 'Primary phone number must be between 10 and 15 digits.',
                'secondary_mobile_number.digits_between' => 'Secondary phone number must be between 10 and 15 digits.',
                'upload_image.file'     => 'The image must be a valid file.',
                'upload_image.mimes'    => 'The image must be a jpeg, png, jpg, or webp.',
                'upload_image.max'      => 'The image size must not exceed 10MB.',
                'aadhar_no.digits'      => 'Aadhar number must be exactly 12 digits.',
                'pan_number.size'       => 'PAN number must be exactly 10 characters.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $uid = Crypt::decrypt($id);
            $row = LabourModel::findOrFail($uid);
            $row->labour_type_id          = $request->labour_type_id;
            $row->name                    = $request->name;
            $row->mobile_number           = $request->mobile_number;
            $row->secondary_mobile_number = $request->secondary_mobile_number;
            $row->dob                     = $request->dob;
            $row->gender                  = $request->gender;
            $row->aadhar_no               = $request->aadhar_no;
            $row->pan_number              = $request->pan_number;
            $row->city                    = $request->city;
            $row->state                   = $request->state;
            $row->address                 = $request->address;
            $row->rate_per_thousand       = $request->rate_per_thousand;
            $row->remarks                 = $request->remarks;

            if ($request->upload_image != "") {
                File::delete(public_path('upload/labour/' . $row->image));
                $image = $request->upload_image;
                $randomStr = Str::random(30);
                $ext = $image->getClientOriginalExtension();
                $imageName = $randomStr . '.' . $ext;
                $image->move(public_path('upload/labour'), $imageName);
                $row->image = $imageName;
            }

            $row->save();

            return redirect()->route('admin.labour.labourList')->with('success', 'Labour successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function deleteLabour($id)
    {
        $id = Crypt::decrypt($id);
        $labour = LabourModel::findOrFail($id);
        // File::delete(public_path('upload/labour/' . $labour->image));
        $labour->delete();
        return redirect()->route('admin.labour.labourList')->with('success', 'Labour deleted successfully!');
    }

    public function labour_details($id)
    {
        try {
            $labourId = Crypt::decrypt($id);
            $labour = LabourModel::select('labours.*', 'labour_types.labour_type')
                ->Join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->where('labours.id', $labourId)
                ->firstOrFail();
            return view('admin.pages.labour.details', compact('labour'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour.labourList')
                ->with('error', 'Invalid Labour ID');
        }
    }

    public function labour_work_details($id)
    {
        try {
            $labourId = Crypt::decrypt($id);
            $labour = LabourModel::select('labours.*', 'labour_types.labour_type as labour_type_name')
                ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->where('labours.id', $labourId)
                ->firstOrFail();

            $labourWorkDetails = DB::table('labour_work_details')
                ->select('bricks_quantity', 'work_date')
                ->where('labour_id', $labourId)
                ->get();

            return view('admin.pages.labour.work-details', compact('labour', 'labourWorkDetails'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour.labourList')
                ->with('error', 'Invalid Labour ID');
        }
    }

    public function labour_payment($id)
    {
        try {
            $labourId = Crypt::decrypt($id);
            $labour = DB::table('labours')
                ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->select('labours.*', 'labour_types.labour_type')
                ->where('labours.id', $labourId)
                ->first();

            if (!$labour) {
                return redirect()->route('admin.labour.labourList')
                    ->with('error', 'Labour not found');
            }

            $payments = DB::table('labour_payments')
                ->where('labour_id', $labourId)
                ->orderBy('id', 'desc')
                ->get();

            return view('admin.pages.labour.payment-details', compact('labour', 'payments'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour.labourList')
                ->with('error', 'Invalid Labour ID');
        }
    }

    public function labour_report_summary($id)
    {
        try {
            $labourId = Crypt::decrypt($id);

            $labour = DB::table('labours')
                ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
                ->select('labours.*', 'labour_types.labour_type')
                ->where('labours.id', $labourId)
                ->first();

            if (!$labour) {
                return redirect()->route('admin.labour.labourList')
                    ->with('error', 'Labour not found');
            }

            $workDetails = DB::table('labour_work_details')
                ->leftJoin('labour_payments', function ($join) {
                    $join->on('labour_work_details.labour_id', '=', 'labour_payments.labour_id')
                        ->whereColumn('labour_work_details.bricks_quantity', '=', 'labour_payments.total_bricks')
                        ->whereRaw('ABS(DATEDIFF(labour_work_details.work_date, labour_payments.payment_date)) <= 5');
                })
                ->select(
                    'labour_work_details.id',
                    'labour_work_details.bricks_quantity',
                    'labour_work_details.work_date',
                    'labour_work_details.is_paid',
                    'labour_work_details.financial_year',
                    'labour_payments.current_payment'
                )
                ->where('labour_work_details.labour_id', $labourId)
                ->orderBy('labour_work_details.id', 'desc')
                ->get();

            $payments = DB::table('labour_payments')
                ->select(
                    'id',
                    'total_bricks',
                    'current_payment',
                    'total_payment',
                    'paid_amount',
                    'due_amount',
                    'payment_date',
                    'financial_year'
                )
                ->where('labour_id', $labourId)
                ->orderBy('id', 'desc')
                ->get();

            return view('admin.pages.labour.report-summary', compact('labour', 'workDetails', 'payments'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour.labourList')
                ->with('error', 'Invalid Labour ID');
        }
    }

}
