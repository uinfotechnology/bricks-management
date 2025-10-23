<?php

namespace App\Http\Controllers\LabourWorkDetails;

use App\Http\Controllers\Controller;
use App\Models\Labour\LabourModel;
use App\Models\LabourWorkDetail\LabourWorkDetailModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LabourWorkDetailsController extends Controller
{
    public function labourWorkDetailsView()
    {
        $labour = LabourModel::select(
            'labours.*',
            'labour_types.labour_type'
        )
            ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
            ->orderBy('labours.name', 'asc')
            ->get();

        return view('admin.pages.labour-work-details.create', compact('labour'));
    }

    public function createlabourWorkDetails(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'labour_id'       => 'required|string|max:255',
            'bricks_quantity' => 'required|string|max:100',
            'date'            => 'required|date',
            'remarks'         => 'nullable|string|max:255',
        ], [
            'labour_id.required' => 'The labour name field is required.',
            'date.date'          => 'The date must be a valid date.',
        ]);

        $labour = new LabourWorkDetailModel();
        $labour->labour_id       = $request->labour_id;
        $labour->bricks_quantity = $request->bricks_quantity;
        $labour->work_date       = $request->date;
        $labour->financial_year  = session('financial_year')['name'] ?? null;
        $labour->remarks         = $request->remarks;
        $labour->save();

        return redirect()->route('admin.labourWorkDetails.labourWorkDetailsList')
            ->with('success', 'Labour Work Details Created Successfully');
    }

    public function labourWorkDetailsList(Request $request)
    {
        if ($request->ajax()) {
            $list = LabourWorkDetailModel::join('labours', 'labour_work_details.labour_id', '=', 'labours.id')
                ->select(
                    'labour_work_details.*',
                    'labours.name as labour_name',
                    'labours.image'
                )
                ->orderBy('labour_work_details.id', 'desc')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset('upload/labour/' . $row->image) . '" width="50" height="50" alt="Labour Image">';
                    }
                    return '-';
                })
                ->editColumn('work_date', function ($row) {
                    return $row->work_date ? \Carbon\Carbon::parse($row->work_date)->format('d-m-Y') : '-';
                })
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.labourWorkDetails.editlabourWorkDetails', Crypt::encryptString($row->id));
                    $deleteRoute = route('admin.labourWorkDetails.deletelabourWorkDetails', Crypt::encrypt($row->id));
                    return '
                    <a class="btn btn-sm btn-warning" href="' . $editRoute . '">Edit</a> 
                    <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure want to delete this product?\')">Delete</button>
                    </form>';
                })
                ->rawColumns(['image', 'action'])
                ->toJson();
        }

        return view('admin.pages.labour-work-details.list');
    }

    public function editlabourWorkDetails($id)
    {
        try {
            $labourId = Crypt::decryptString($id);
            $labour = LabourWorkDetailModel::findOrFail($labourId);
            $list = LabourModel::orderBy('id', 'desc')->get();
            return view('admin.pages.labour-work-details.edit', compact('labour', 'list'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labourWorkDetails.labourWorkDetailsList')
                ->with('error', 'Invalid Data ID');
        }
    }

    public function updatelabourWorkDetails($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'labour_id'       => 'required|string|max:255',
                'bricks_quantity' => 'required|string|max:100',
                'date'            => 'required|date',
                'remarks'         => 'nullable|string|max:255',
            ], [
                'labour_id.required' => 'The labour name field is required.',
                'date.date'          => 'The date must be a valid date.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $uid = Crypt::decrypt($id);
            $row = LabourWorkDetailModel::findOrFail($uid);
            $row->labour_id       = $request->labour_id;
            $row->bricks_quantity = $request->bricks_quantity;
            $row->work_date       = $request->date;
            $row->remarks         = $request->remarks;
            $row->save();

            return redirect()->route('admin.labourWorkDetails.labourWorkDetailsList')->with('success', 'Labour Work Details successfully updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    public function deletelabourWorkDetails($id)
    {
        $id = Crypt::decrypt($id);
        $labour = LabourWorkDetailModel::findOrFail($id);
        $labour->delete();
        return redirect()->route('admin.labourWorkDetails.labourWorkDetailsList')->with('success', 'Labour work details deleted successfully!');
    }

    public function labourWorkDetailsFiltar()
    {
        $labour = LabourModel::orderBy('id', 'desc')->get();
        return view('admin.pages.labour-work-details.filtar-data-list', compact('labour'));
    }

    public function getLabourWorkDetailsFiltar(Request $request)
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

        $workDetails = DB::table('labour_work_details')
            ->join('labours', 'labour_work_details.labour_id', '=', 'labours.id')
            ->join('labour_types', 'labours.labour_type_id', '=', 'labour_types.id')
            ->select(
                'labour_work_details.*',
                'labours.name as labour_name',
                'labours.mobile_number',
                'labour_types.labour_type',
                'labours.image',
                'labours.address',
                'labours.city',
                'labours.state',
                'labours.gender',
                'labours.aadhar_no',
                'labours.pan_number',
                'labours.rate_per_thousand',
            )
            ->where('labour_work_details.labour_id', $request->labour_id)
            ->whereBetween('labour_work_details.work_date', [$request->from_date, $request->to_date])
            ->orderBy('labour_work_details.work_date', 'asc')
            ->get();

        return view('admin.pages.labour-work-details.filtar-data-list', [
            'labour'           => $labour,
            'workDetails'      => $workDetails,
            'selectedLabourId' => $request->labour_id,
            'selectedFromDate' => $request->from_date,
            'selectedToDate'   => $request->to_date,
        ]);
    }
}
