<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use App\Models\stock\StockModel;
use App\Models\StockTransaction\StockTransactionModel;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function stockList(Request $request)
    {
        if ($request->ajax()) {
            $list = StockModel::select('stocks.*', 'products.product_name')
                ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
                ->orderBy('stocks.id', 'DESC')
                ->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.stock.list');
    }

    public function useStockEntry()
    {
        $products = DB::table('products')
            ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->select('products.*', 'stocks.quantity as stock_quantity')
            ->get();

        return view('admin.pages.stock.add', compact('products'));
    }

    public function storeUseStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
        ], [
            'product_id.required' => 'The product field is required.',
        ]);

        $productId = $request->product_id;
        $usedQty   = $request->quantity;

        $stock = DB::table('stocks')->where('product_id', $productId)->first();

        if (!$stock || $stock->quantity < $usedQty) {
            return back()->withErrors(['quantity' => 'Stock is not enough!']);
        }

        DB::table('stocks')->where('product_id', $productId)->update([
            'quantity'    => $stock->quantity - $usedQty,
            'updated_at'  => now()
        ]);

        DB::table('stock_transactions')->insert([
            'product_id'        => $productId,
            'purchase_id'       => null,
            'party_id'          => null,
            'quantity'          => $usedQty,
            'unit'              => $stock->unit ?? 'kilogram',
            'rate'              => 0,
            'gst'               => 0,
            'total_amount'      => 0,
            'transaction_type'  => 'Use',
            'date'              => now()->toDateString(),
            'financial_year'    => session('financial_year')['name'] ?? null,
            'remarks'           => 'Stock used in production',
            'created_at'        => now(),
            'updated_at'        => now()
        ]);

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }

    public function useStockList(Request $request)
    {
        if ($request->ajax()) {
            $list = StockTransactionModel::select(
                'stock_transactions.*',
                'products.product_name'
            )
                ->join('products', 'stock_transactions.product_id', '=', 'products.id')
                ->where('stock_transactions.transaction_type', 'Use')
                ->orderBy('stock_transactions.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->toJson();
        }
        return view('admin.pages.stock.use-list');
    }

    public function stockTransactionList(Request $request)
    {
        if ($request->ajax()) {
            $list = StockTransactionModel::select(
                'stock_transactions.*',
                'products.product_name',
                'account.party_name'
            )
                ->leftJoin('products', 'stock_transactions.product_id', '=', 'products.id')
                ->leftJoin('account', 'stock_transactions.party_id', '=', 'account.id')
                ->orderBy('stock_transactions.id', 'DESC')
                ->get();

            return DataTables::of($list)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('admin.pages.stock.stock-transaction');
    }

    public function useStockFilter()
    {
        $getProduct = ProductModel::orderBy('id', 'desc')->get();
        return view('admin.pages.stock.filter-data-list', compact('getProduct'));
    }

    public function getUseStockFilter(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
        ], [
            'product_id.required' => 'The product field is required.',
            'from_date.date'      => 'The from date must be a valid date.',
            'to_date.date'        => 'The to date must be on or after the from date.',
        ]);

        $getProduct = ProductModel::orderBy('id', 'desc')->get();
        
        $useStockDetails = DB::table('stock_transactions')
            ->join('products', 'stock_transactions.product_id', '=', 'products.id')
            ->select(
                'stock_transactions.*',
                'products.product_name'
            )
            ->where('stock_transactions.transaction_type', 'Use')
            ->where('stock_transactions.product_id', $request->product_id)
            ->whereBetween('stock_transactions.date', [$request->from_date, $request->to_date])
            ->orderBy('stock_transactions.date', 'asc')
            ->get();

        return view('admin.pages.stock.filter-data-list', [
            'getProduct'        => $getProduct,
            'useStockDetails'   => $useStockDetails,
            'selectedProductId' => $request->product_id,
            'selectedFromDate'  => $request->from_date,
            'selectedToDate'    => $request->to_date,
        ]);
    }
}
