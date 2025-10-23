<?php

namespace App\Http\Controllers\BricksStock;

use App\Http\Controllers\Controller;
use App\Models\BricksStock\BricksStockModel;
use App\Models\BricksStockTransaction\BricksStockTransactionModel;
use App\Models\BricksTypeCategory\BricksTypeCategoryModel;
use App\Models\BricksTypeSubCategory\BricksTypeSubCategoryModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BricksStockController extends Controller
{
    public function createBricksStockView()
    {
        $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
        $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();
        return view('admin.pages.bricks-stock.create', compact('category', 'subCategory'));
    }

    public function storeBricksStock(Request $request)
    {
        // Validate request
        $request->validate([
            'bricks_quantity'             => 'required|integer|min:1',
            'bricks_type_category_id'     => 'required|integer',
            'bricks_type_sub_category_id' => 'nullable|integer',
            'date'                        => 'required|date',
        ], [
            'date.date' => 'The date must be in a valid format.',
            'bricks_type_category_id.required' => 'Selecting a bricks type category is mandatory.',
        ]);

        DB::beginTransaction();

        try {
            // Get category and subcategory names
            $categoryName = DB::table('bricks_type_categorys')
                ->where('id', $request->bricks_type_category_id)
                ->value('bricks_type_category_name');

            $subCategoryName = $request->bricks_type_sub_category_id
                ? DB::table('bricks_type_sub_categorys')
                ->where('id', $request->bricks_type_sub_category_id)
                ->value('bricks_type_sub_category_name')
                : null;

            // Check if stock already exists
            $stock = BricksStockModel::where('bricks_type_category_id', $request->bricks_type_category_id)
                ->where('bricks_type_sub_category_id', $request->bricks_type_sub_category_id)
                ->first();

            if ($stock) {
                $stock->bricks_quantity += $request->bricks_quantity;
                $stock->bricks_type_category_name = $categoryName;
                $stock->bricks_type_sub_category_name = $subCategoryName;
            } else {
                $stock = new BricksStockModel();
                $stock->bricks_type_category_id = $request->bricks_type_category_id;
                $stock->bricks_type_sub_category_id = $request->bricks_type_sub_category_id;
                $stock->bricks_quantity = $request->bricks_quantity;
                $stock->bricks_type_category_name = $categoryName;
                $stock->bricks_type_sub_category_name = $subCategoryName;
            }

            $stock->save();

            // Record transaction
            $transaction = new BricksStockTransactionModel();
            $transaction->stock_id = $stock->id;
            $transaction->bricks_type_category_id = $request->bricks_type_category_id;
            $transaction->bricks_type_sub_category_id = $request->bricks_type_sub_category_id;
            $transaction->bricks_quantity = $request->bricks_quantity;
            $transaction->stock_date = $request->date;
            $transaction->transaction_type = 'IN';
            $transaction->financial_year = session('financial_year')['name'] ?? null;
            $transaction->save();

            DB::commit();

            return redirect()->route('admin.bricks_stock.BricksStock')
                ->with('success', 'Bricks stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function BricksStock(Request $request)
    {
        if ($request->ajax()) {
            $list = BricksStockModel::select(
                'id',
                'bricks_type_category_name',
                'bricks_type_sub_category_name',
                'bricks_quantity'
            )->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->toJson();
        }

        return view('admin.pages.bricks-stock.bricks-stock');
    }

    public function BricksStockList(Request $request)
    {
        if ($request->ajax()) {
            $list = BricksStockTransactionModel::leftJoin('bricks_type_categorys', 'bricks_stocks_transactions.bricks_type_category_id', '=', 'bricks_type_categorys.id')
                ->leftJoin('bricks_type_sub_categorys', 'bricks_stocks_transactions.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
                ->select(
                    'bricks_stocks_transactions.*',
                    'bricks_type_categorys.bricks_type_category_name',
                    'bricks_type_sub_categorys.bricks_type_sub_category_name'
                )
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.bricks_stock.editBricksStock', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.bricks_stock.deleteBricksStock', Crypt::encrypt($row->id));
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

        return view('admin.pages.bricks-stock.list');
    }

    public function editBricksStock($id)
    {
        try {
            $dataId = Crypt::decrypt($id);

            $data = BricksStockTransactionModel::select(
                'bricks_stocks_transactions.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name'
            )
                ->leftJoin('bricks_type_categorys', 'bricks_type_categorys.id', '=', 'bricks_stocks_transactions.bricks_type_category_id')
                ->leftJoin('bricks_type_sub_categorys', 'bricks_type_sub_categorys.id', '=', 'bricks_stocks_transactions.bricks_type_sub_category_id')
                ->where('bricks_stocks_transactions.id', $dataId)
                ->firstOrFail();

            $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
            $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();

            return view('admin.pages.bricks-stock.edit', compact('data', 'category', 'subCategory'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bricks_stock.BricksStockList')
                ->with('error', 'Invalid ID');
        }
    }

    public function updateBricksStock(Request $request, $id)
    {
        $dataId = Crypt::decrypt($id);
        $transaction = BricksStockTransactionModel::findOrFail($dataId);

        $request->validate([
            'bricks_quantity'             => 'required|integer|min:1',
            'bricks_type_category_id'     => 'required|integer',
            'bricks_type_sub_category_id' => 'nullable|integer',
            'date'                        => 'required|date',
        ], [
            'date.date' => 'The date must be in a valid format.',
            'bricks_type_category_id.required' => 'Selecting a bricks type category is mandatory.',
        ]);

        DB::beginTransaction();

        try {
            $categoryName = DB::table('bricks_type_categorys')
                ->where('id', $request->bricks_type_category_id)
                ->value('bricks_type_category_name');

            $subCategoryName = $request->bricks_type_sub_category_id
                ? DB::table('bricks_type_sub_categorys')
                ->where('id', $request->bricks_type_sub_category_id)
                ->value('bricks_type_sub_category_name')
                : null;

            $stock = BricksStockModel::where('id', $transaction->stock_id)->first();

            if (!$stock) {
                throw new \Exception('Stock record not found.');
            }

            $stock->bricks_quantity -= $transaction->bricks_quantity;

            $stock->bricks_type_category_id = $request->bricks_type_category_id;
            $stock->bricks_type_sub_category_id = $request->bricks_type_sub_category_id;
            $stock->bricks_type_category_name = $categoryName;
            $stock->bricks_type_sub_category_name = $subCategoryName;

            $stock->bricks_quantity += $request->bricks_quantity;
            $stock->save();

            $transaction->update([
                'bricks_type_category_id'     => $request->bricks_type_category_id,
                'bricks_type_sub_category_id' => $request->bricks_type_sub_category_id,
                'bricks_quantity'             => $request->bricks_quantity,
                'stock_date'                  => $request->date,
            ]);

            DB::commit();

            return redirect()->route('admin.bricks_stock.BricksStock')
                ->with('success', 'Bricks stock updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function deleteBricksStock($id)
    {
        try {
            DB::beginTransaction();
            $dataId = Crypt::decrypt($id);
            $transaction = BricksStockTransactionModel::findOrFail($dataId);

            $stock = BricksStockModel::where('id', $transaction->stock_id)->first();

            if (!$stock) {
                return redirect()->route('admin.bricks_stock.BricksStockList')
                    ->with('error', 'Stock record not found!');
            }

            $newQuantity = $stock->bricks_quantity - $transaction->bricks_quantity;
            $stock->bricks_quantity = max(0, $newQuantity);
            $stock->save();
            $transaction->delete();

            DB::commit();

            return redirect()->route('admin.bricks_stock.BricksStockList')
                ->with('success', 'Bricks stock transaction deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.bricks_stock.BricksStockList')
                ->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    public function bricksStockFilter()
    {
        $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
        $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();

        $getData = collect();

        return view('admin.pages.bricks-stock.filter-data-list', compact('getData', 'category', 'subCategory'));
    }

    public function getBricksStockFilter(Request $request)
    {
        $request->validate([
            'bricks_type_category_id'     => 'required|integer',
            'from_date'                   => 'required|date',
            'to_date'                     => 'required|date|after_or_equal:from_date',
        ], [
            'bricks_type_category_id.required' => 'Please select a category.',
            'from_date.required'               => 'Please select the starting date.',
            'to_date.required'                 => 'Please select the ending date.',
        ]);

        $query = BricksStockTransactionModel::join('bricks_type_categorys', 'bricks_stocks_transactions.bricks_type_category_id', '=', 'bricks_type_categorys.id')
            ->leftJoin('bricks_type_sub_categorys', 'bricks_stocks_transactions.bricks_type_sub_category_id', '=', 'bricks_type_sub_categorys.id')
            ->select(
                'bricks_stocks_transactions.*',
                'bricks_type_categorys.bricks_type_category_name',
                'bricks_type_sub_categorys.bricks_type_sub_category_name'
            )
            ->where('bricks_stocks_transactions.bricks_type_category_id', $request->bricks_type_category_id)
            ->whereDate('bricks_stocks_transactions.stock_date', '>=', $request->from_date)
            ->whereDate('bricks_stocks_transactions.stock_date', '<=', $request->to_date);

        if ($request->filled('bricks_type_sub_category_id')) {
            $query->where('bricks_stocks_transactions.bricks_type_sub_category_id', $request->bricks_type_sub_category_id);
        }

        $getData = $query->orderBy('bricks_stocks_transactions.id', 'desc')->get();

        $category = BricksTypeCategoryModel::orderBy('id', 'desc')->get();
        $subCategory = BricksTypeSubCategoryModel::orderBy('id', 'desc')->get();

        return view('admin.pages.bricks-stock.filter-data-list', [
            'getData'             => $getData,
            'category'            => $category,
            'subCategory'         => $subCategory,
            'selectedCategory'    => $request->bricks_type_category_id,
            'selectedSubCategory' => $request->bricks_type_sub_category_id,
            'selectedFromDate'    => $request->from_date,
            'selectedToDate'      => $request->to_date,
        ]);
    }
}
