<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    public function createView(){

        $accountType = ['Coal','Soil','Pathera','Loading Labour','Unloading Labour'];

        return view('admin.pages.account.create', compact('accountType'));
    }
    public function create(Request $request){
        // dd($request->all());

        $request->validate([
            'account_type'             => 'required|string|max:255',
            'party_name'               => 'required|string|max:255',
            'contact_person'           => 'nullable|string|max:255',
            'mobile_number'            => 'required|digits_between:10,15',
            'secondary_mobile_number'  => 'nullable|digits_between:10,15',
            'gst_number'               => 'nullable|string|max:15',
            'pan_number'               => 'nullable|string|max:10',
            'opening_balance'          => 'required|min:0',
            'address'                  => 'nullable|string|max:500',
            'bank_name'                => 'nullable|string|max:255',
            'account_number'           => 'nullable|string|max:30',
            'ifsc_code'                => 'nullable|string|max:11',
            'account_holder_name'      => 'nullable|string|max:255',
            'remarks'                  => 'nullable|string|max:500',
            'created_date'             => 'required|date',
        ], [
            'mobile_number.digits_between' => 'Mobile number must be between 10 and 15 digits.',
            'secondary_mobile_number.digits_between' => 'Secondary mobile number must be between 10 and 15 digits.',
        ]);

        AccountModel::create([
            'account_type' => $request->account_type,
            'party_name' => $request->party_name,
            'contact_person' => $request->contact_person,
            'mobile_number' => $request->mobile_number,
            'secondary_mobile_number' => $request->secondary_mobile_number,
            'gst_number' => $request->gst_number,
            'pan_number' => $request->pan_number,
            'opening_balance' => $request->opening_balance,
            'address' => $request->address,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code'  => $request->ifsc_code,
            'account_holder_name' => $request->account_holder_name,
            'remarks' => $request->remarks,
            'date' => $request->created_date,
        ]);

        return redirect()->back()->with('success','New Account has been created');

    }

    public function accountList(Request $request){

        if($request->ajax()){
            $list = AccountModel::orderBy('id','DESC')->get();
            return DataTables::of($list)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $editRoute = route('admin.account.editAccount',Crypt::encrypt($row->id));
                $deleteRoute = route('admin.account.deleteAccount',Crypt::encrypt($row->id));
                $ledgerRoute = route('admin.account.accountLedger',Crypt::encrypt($row->id));

                return '<a class="btn btn-sm btn-warning" href="'.$editRoute.'" >Edit</a> <a class="btn btn-sm btn-info" href="'.$ledgerRoute.'">Ledger</a> <a class="btn btn-sm btn-danger" href="'.$deleteRoute.'" >Delete</a> ';
            })
            ->rawColumns(['action'])->toJson();
        }

        return view('admin.pages.account.list');
    }

}
