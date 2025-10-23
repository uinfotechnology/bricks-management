@extends('admin.include.layout')

@push('title')
    Use Stock Entry
@endpush

@section('layout')
<div class="dashboard-main-body">

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Use Stock Entry</h5>
                </div>

                <div class="card-body">

                    <!-- Info Section (Selected Product Stock Show) -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <div class="card p-3 border h-100">
                                    <p class="mb-1 text-muted small">Selected Product</p>
                                    <h6 class="mb-0" id="selectedProduct">-</h6>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="card p-3 border h-100">
                                    <p class="mb-1 text-muted small">Available Stock</p>
                                    <h6 class="mb-0" id="availableStock">-</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form class="row gy-3 needs-validation" method="POST"
                          action="{{ route('admin.stock.storeUseStock') }}" novalidate>
                        @csrf

                        <!-- Product -->
                        <div class="col-md-6">
                            <label class="form-label">Product <span class="text-danger">*</span> </label>
                            <select name="product_id" id="productSelect" class="form-control">
                                <option value="">Select Product</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->id }}"
                                            data-stock="{{ $item->stock_quantity ?? 0 }}"
                                            data-name="{{ $item->product_name }}">
                                        {{ $item->product_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6">
                            <label class="form-label">Quantity Used (in KG) <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control"
                                   placeholder="Enter Quantity in KG" value="{{ old('quantity') }}">
                            @error('quantity')
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

<!-- JavaScript -->
<script>
document.getElementById('productSelect').addEventListener('change', function () {
    let selected = this.options[this.selectedIndex];
    let stock = selected.getAttribute('data-stock');
    let name = selected.getAttribute('data-name');

    document.getElementById('selectedProduct').innerText = name ? name : '-';
    document.getElementById('availableStock').innerText = stock ? stock + ' KG' : '0 KG';
});
</script>
@endsection
