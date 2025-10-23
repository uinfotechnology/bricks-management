<?php

namespace App\Http\Controllers\BricksTypeSubCategory;

use App\Http\Controllers\Controller;
use App\Models\BricksTypeCategory\BricksTypeCategoryModel;
use App\Models\BricksTypeSubCategory\BricksTypeSubCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BricksTypeSubCategoryController extends Controller
{
    public function bricksTypeSubCategoryList(Request $request)
    {
        if ($request->ajax()) {
            $list = DB::table('bricks_type_sub_categorys as sub')
                ->join('bricks_type_categorys as cat', 'sub.bricks_type_category_id', '=', 'cat.id')
                ->select(
                    'sub.id',
                    'cat.bricks_type_category_name',
                    'sub.bricks_type_sub_category_name',
                    'sub.financial_year',
                    'sub.created_at',
                    'sub.updated_at'
                )
                ->whereNull('sub.deleted_at')
                ->orderBy('sub.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.bricks_type_sub_category.editBricksTypeSubCategory', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.bricks_type_sub_category.deleteBricksTypeSubCategory', Crypt::encrypt($row->id));
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

        $category = BricksTypeCategoryModel::orderBy('id', 'DESC')->get();
        return view('admin.pages.bricks-type-sub-category.list', compact('category'));
    }

    public function storeBricksTypeSubCategory(Request $request)
    {
        $request->validate([
            'bricks_type_category_id' => 'required',
            'bricks_type_sub_category_name' => 'required|string|max:255',
        ], [
            'bricks_type_category_id.required' => 'The bricks type category field is required.',
            'bricks_type_sub_category_name.required' => 'The bricks type sub category field is required.',
        ]);

        BricksTypeSubCategoryModel::create([
            'bricks_type_category_id'       => $request->bricks_type_category_id,
            'bricks_type_sub_category_name' => $request->bricks_type_sub_category_name,
            'financial_year'                => session('financial_year')['name'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Bricks type sub category has been created');
    }

    public function editBricksTypeSubCategory($id)
    {
        try {
            $dataId = Crypt::decrypt($id);
            $data = BricksTypeSubCategoryModel::findOrFail($dataId);
            $category = BricksTypeCategoryModel::all();
            return view('admin.pages.bricks-type-sub-category.edit', compact('data', 'category'));
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.bricks_type_sub_category.bricksTypeSubCategoryList')
                ->with('error', $e->getMessage());
        }
    }

    public function updateBricksTypeSubCategory(Request $request, $id)
    {
        $dataId = Crypt::decrypt($id);
        $data = BricksTypeSubCategoryModel::findOrFail($dataId);

        $request->validate([
            'bricks_type_category_id' => 'required',
            'bricks_type_sub_category_name' => 'required|string|max:255',
        ], [
            'bricks_type_category_id.required' => 'The bricks type category field is required.',
            'bricks_type_sub_category_name.required' => 'The bricks type sub category field is required.',
        ]);

        $data->update([
            'bricks_type_category_id'       => $request->bricks_type_category_id,
            'bricks_type_sub_category_name' => $request->bricks_type_sub_category_name,
        ]);
        return redirect()->route('admin.bricks_type_sub_category.bricksTypeSubCategoryList')
            ->with('success', 'Bricks Type Sub Category Updated Successfully');
    }

    public function deleteBricksTypeSubCategory($id)
    {
        $id = Crypt::decrypt($id);
        $data = BricksTypeSubCategoryModel::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.bricks_type_sub_category.bricksTypeSubCategoryList')->with('success', 'Data deleted successfully!');
    }
}
