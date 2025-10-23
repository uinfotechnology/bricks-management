<?php

namespace App\Http\Controllers\BricksTypeCategory;

use App\Http\Controllers\Controller;
use App\Models\BricksTypeCategory\BricksTypeCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class BricksTypeCategoryController extends Controller
{
    public function bricksTypeCategoryList(Request $request)
    {
        if ($request->ajax()) {
            $list = BricksTypeCategoryModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.bricks_type_category.editBricksTypeCategory', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.bricks_type_category.deleteBricksTypeCategory', Crypt::encrypt($row->id));
                    return '
                    <a class="btn btn-sm btn-warning" href="' . $editRoute . '">Edit</a>
                    <form action="' . $deleteRoute . '" method="POST" style="display:inline-block;">
                        ' . csrf_field() . method_field("DELETE") . '
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure want to delete this product?\')">Delete</button>
                    </form>
                    ';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.bricks-type-category.list');
    }

    public function storeBricksTypeCategory(Request $request)
    {
        $request->validate([
            'bricks_type_category_name' => 'required|string|max:255',
        ], [
            'bricks_type_category_name.required' => 'The bricks type category field is required.',
        ]);

        BricksTypeCategoryModel::create([
            'bricks_type_category_name' => $request->bricks_type_category_name,
            'financial_year' => session('financial_year')['name'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Bricks type category has been created');
    }

    public function editBricksTypeCategory($id)
    {
        try {
            $datatId = Crypt::decrypt($id);
            $data = BricksTypeCategoryModel::findOrFail($datatId);
            return view('admin.pages.bricks-type-category.edit', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_type_category.bricksTypeCategoryList')
                ->with('error', 'Invalid Category ID');
        }
    }

    public function updateBricksTypeCategory(Request $request, $id)
    {
        $dataId = Crypt::decrypt($id);
        $data = BricksTypeCategoryModel::findOrFail($dataId);
        $request->validate([
            'bricks_type_category_name' => 'required|string|max:255',
        ]);
        $data->update([
            'bricks_type_category_name' => $request->bricks_type_category_name,
        ]);
        return redirect()->route('admin.bricks_type_category.bricksTypeCategoryList')
            ->with('success', 'Bricks Type Category Updated Successfully');
    }

    public function deleteBricksTypeCategory($id)
    {
        $id = Crypt::decrypt($id);
        $data = BricksTypeCategoryModel::findOrFail($id);

        $data->delete();

        return redirect()->route('admin.bricks_type_category.bricksTypeCategoryList')->with('success', 'Data deleted successfully!');
    }
}
