<?php

namespace App\Http\Controllers\LabourType;

use App\Http\Controllers\Controller;
use App\Models\LabourType\LabourTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class LabourTypeController extends Controller
{
    public function labourTypeView()
    {
        return view('admin.pages.labour-type.create');
    }

    public function createLabourType(Request $request)
    {
        $request->validate([
            'labour_type' => 'required|string|max:255',
        ]);

        $labour = new LabourTypeModel();
        $labour->labour_type = $request->labour_type;
        $labour->save();

        return redirect()->route('admin.labour_type.labourTypeList')
            ->with('success', 'Labour Type Created Successfully');
    }

    public function labourTypeList(Request $request)
    {
        if ($request->ajax()) {
            $list = LabourTypeModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.labour_type.editLabourType', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.labour_type.deleteLabourType', Crypt::encrypt($row->id));
                    return '
                    <a class="btn btn-sm btn-warning" href="' . $editRoute . '">Edit</a>
                    <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure want to delete this data?\')">Delete</button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.labour-type.list');
    }

    public function editLabourType($id)
    {
        try {
            $productId = Crypt::decrypt($id);
            $product = LabourTypeModel::findOrFail($productId);
            return view('admin.pages.labour-type.edit', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.labour_type.labourTypeList')
                ->with('error', 'Invalid Product ID');
        }
    }

    public function updateLabourType(Request $request, $id)
    {
        $accountId = Crypt::decrypt($id);
        $account = LabourTypeModel::findOrFail($accountId);
        $request->validate([
            'labour_type' => 'required|string|max:255',
        ]);
        $account->update([
            'labour_type' => $request->labour_type,
        ]);
        return redirect()->route('admin.labour_type.labourTypeList')
            ->with('success', 'Data Updated Successfully');
    }

    public function deleteLabourType($id)
    {
        $id = Crypt::decrypt($id);
        $product = LabourTypeModel::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.labour_type.labourTypeList')->with('success', 'Data deleted successfully!');
    }
}
