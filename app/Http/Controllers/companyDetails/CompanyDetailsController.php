<?php

namespace App\Http\Controllers\CompanyDetails;

use App\Http\Controllers\Controller;
use App\Models\CompanyDetails\CompanyDetailModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CompanyDetailsController extends Controller
{
    public function companyDetailsView()
    {
        return view('admin.pages.company-details.list');
    }

    public function companyDetailsForm()
    {
        return view('admin.pages.company-details.form');
    }

    public function storeCompanyDetails(Request $request)
    {
        $request->validate([
            'company_name'        => 'required|string|max:255',
            'registration_number' => 'required|string|max:100',
            'phone'               => 'required|digits_between:10,15',
            'address'             => 'required|string|max:500',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|max:10',
            'gst_number'          => 'required|string|max:20',
            'pan_number'          => 'required|string|max:20',
            'tan_number'          => 'required|string|max:20',
            'bank_name'           => 'required|string|max:100',
            'account_number'      => 'required|string|max:30',
            'ifsc_code'           => 'required|string|max:20',
            'account_holder_name' => 'required|string|max:100',
            'upload_image'        => 'required|file|mimes:jpeg,png,jpg,webp|max:10240',
        ], [
            'phone.digits_between'  => 'Phone number must be between 10 and 15 digits.',
            'upload_image.required' => 'The image field is required.',
            'upload_image.file'     => 'The image must be a valid file.',
            'upload_image.mimes'    => 'The image must be a jpeg, png, jpg, or webp.',
            'upload_image.max'      => 'The image size must not exceed 10MB.',
        ]);

        $company = new CompanyDetailModel();
        $company->company_name        = $request->company_name;
        $company->registration_number = $request->registration_number;
        $company->phone               = $request->phone;
        $company->address             = $request->address;
        $company->city                = $request->city;
        $company->state               = $request->state;
        $company->pincode             = $request->pincode;
        $company->gst_number          = $request->gst_number;
        $company->pan_number          = $request->pan_number;
        $company->tan_number          = $request->tan_number;
        $company->bank_name           = $request->bank_name;
        $company->account_number      = $request->account_number;
        $company->ifsc_code           = $request->ifsc_code;
        $company->account_holder_name = $request->account_holder_name;

        if ($request->hasFile('upload_image')) {
            $file = $request->file('upload_image');
            $randomStr = Str::random(30);
            $filename = $randomStr . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/company'), $filename);
            $company->image = $filename;
        }

        $company->save();

        return redirect()->route('admin.dashboard')->with('success', 'Company Details Saved Successfully');
    }

    public function companyDetailsList(Request $request)
    {
        if ($request->ajax()) {
            $list = CompanyDetailModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.company_details.editCompanyDetails', Crypt::encrypt($row->id));

                    return '<a class="btn btn-sm btn-warning" href="' . $editRoute . '" >Edit</a>';
                })
                ->rawColumns(['action'])->toJson();
        }

        return view('admin.pages.company-details.list');
    }

    public function editCompanyDetails($id)
    {
        try {
            $companyId = Crypt::decrypt($id);
            $company = CompanyDetailModel::findOrFail($companyId);

            return view('admin.pages.company-details.edit', compact('company'));
        } catch (\Exception $e) {
            return redirect()->route('admin.company_details.companyDetailsView')
                ->with('error', 'Invalid Company Details ID');
        }
    }

    public function updateCompanyDetails(Request $request, $id)
    {
        $companyId = Crypt::decrypt($id);
        $company = CompanyDetailModel::findOrFail($companyId);

        $request->validate([
            'company_name'        => 'required|string|max:255',
            'registration_number' => 'required|string|max:100',
            'phone'               => 'required|digits_between:10,15',
            'address'             => 'required|string|max:500',
            'city'                => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|max:10',
            'gst_number'          => 'required|string|max:20',
            'pan_number'          => 'required|string|max:20',
            'tan_number'          => 'required|string|max:20',
            'bank_name'           => 'required|string|max:100',
            'account_number'      => 'required|string|max:30',
            'ifsc_code'           => 'required|string|max:20',
            'account_holder_name' => 'required|string|max:100',
            'upload_image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'phone.digits_between'  => 'Phone number must be between 10 and 15 digits.',
            'upload_image.required' => 'The image field is required.',
            'upload_image.file'     => 'The image must be a valid file.',
            'upload_image.mimes'    => 'The image must be a jpeg, png, jpg, or webp.',
            'upload_image.max'      => 'The image size must not exceed 10MB.',
        ]);

        $company->update([
            'company_name'        => $request->company_name,
            'registration_number' => $request->registration_number,
            'phone'               => $request->phone,
            'address'             => $request->address,
            'city'                => $request->city,
            'state'               => $request->state,
            'pincode'             => $request->pincode,
            'gst_number'          => $request->gst_number,
            'pan_number'          => $request->pan_number,
            'tan_number'          => $request->tan_number,
            'bank_name'           => $request->bank_name,
            'account_number'      => $request->account_number,
            'ifsc_code'           => $request->ifsc_code,
            'account_holder_name' => $request->account_holder_name,
        ]);

        if ($request->hasFile('upload_image')) {
            if ($company->image && File::exists(public_path('upload/company/' . $company->image))) {
                File::delete(public_path('upload/company/' . $company->image));
            }

            $image = $request->file('upload_image');
            $imageName = Str::random(30) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/company'), $imageName);
            $company->image = $imageName;
            $company->save();
        }

        return redirect()->route('admin.company_details.companyDetailsView')
            ->with('success', 'Company Details Updated Successfully');
    }
}
