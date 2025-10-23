<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function createProductView()
    {
        return view('admin.pages.product.create');
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
        ]);

        ProductModel::create([
            'product_name'   => $request->product_name,
            'financial_year' => session('financial_year')['name'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Product has been created');
    }

    public function productList(Request $request)
    {
        if ($request->ajax()) {
            $list = ProductModel::orderBy('id', 'DESC')->get();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editRoute = route('admin.product.editProduct', Crypt::encrypt($row->id));
                    $deleteRoute = route('admin.product.deleteProduct', Crypt::encrypt($row->id));
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

        return view('admin.pages.product.list');
    }

    public function editProduct($id)
    {
        try {
            $productId = Crypt::decrypt($id);
            $product = ProductModel::findOrFail($productId);
            return view('admin.pages.product.edit', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.product.productList')
                ->with('error', 'Invalid Product ID');
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $accountId = Crypt::decrypt($id);
        $account = ProductModel::findOrFail($accountId);
        $request->validate([
            'product_name'            => 'required|string|max:255',
        ]);
        $account->update([
            'product_name'            => $request->product_name,
        ]);
        return redirect()->route('admin.product.productList')
            ->with('success', 'Product Updated Successfully');
    }

    public function deleteProduct($id)
    {
        $id = Crypt::decrypt($id);
        $product = ProductModel::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.product.productList')->with('success', 'Product deleted successfully!');
    }
}
