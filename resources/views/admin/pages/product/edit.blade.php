@extends('admin.include.layout')

@push('title')
    Update Product
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Product</h5>
                        <div>
                            <a href="{{ route('admin.product.productList') }}" class="btn btn-sm btn-primary">Product List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.product.updateProduct', Crypt::encrypt($product->id)) }}" novalidate>
                            @csrf

                            <!-- Product -->
                            <div class="col-md-12">
                                <label class="form-label">Product <span class="text-danger">*</span></label>
                                <input type="text" name="product_name" class="form-control" placeholder="Enter Product"
                                    value="{{ old('product_name', $product->product_name) }}">
                                @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
