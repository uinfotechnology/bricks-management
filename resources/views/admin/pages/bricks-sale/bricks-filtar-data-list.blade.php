@extends('admin.include.layout')

@push('title')
    Customer Wise Bricks Sale Filter
@endpush

@section('layout')
<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Customer Wise Bricks Sale Filter</h5>
                    <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks Sale List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bricks_sale.getBricksWiseFilter') }}" class="row gy-3">
                        @csrf

                        <!-- Category -->
                        <div class="col-md-3">
                            <label class="form-label">Bricks Type Category <span class="text-danger">*</span></label>
                            <select name="bricks_type_category_id" id="bricks_type_category" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}" {{ (isset($selectedCategory) && $selectedCategory == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->bricks_type_category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bricks_type_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Sub Category -->
                        <div class="col-md-3">
                            <label class="form-label">Bricks Sub Category</label>
                            <select name="bricks_type_sub_category_id" id="bricks_type_sub_category" class="form-control">
                                <option value="">Select Sub Category</option>
                                @foreach ($subCategory as $sub)
                                    @if(isset($selectedCategory) && $sub->bricks_type_category_id == $selectedCategory)
                                        <option value="{{ $sub->id }}" {{ (isset($selectedSubCategory) && $selectedSubCategory == $sub->id) ? 'selected' : '' }}>
                                            {{ $sub->bricks_type_sub_category_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('bricks_type_sub_category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- From Date -->
                        <div class="col-md-2">
                            <label class="form-label">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="from_date" class="form-control" value="{{ $selectedFromDate ?? '' }}" required>
                            @error('from_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- To Date -->
                        <div class="col-md-2">
                            <label class="form-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" name="to_date" class="form-control" value="{{ $selectedToDate ?? '' }}" required>
                            @error('to_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Filtered Data Table --}}
            @isset($details)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filtered Bricks Sale Details</h5>
                    </div>
                    <div class="card-body">
                        @if ($details->isEmpty())
                            <p class="text-danger">No records found for the selected category and date range.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Bill No</th>
                                        <th>Customer Name</th>
                                        <th>Bricks Type</th>
                                        <th>Bricks Sub Type</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Sale Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->bill_no }}</td>
                                            <td>{{ $item->customer_name }}</td>
                                            <td>{{ $item->bricks_type_category_name }}</td>
                                            <td>{{ $item->bricks_type_sub_category_name ?? '' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total_amount, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->sale_date)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>

<script>
    const subCategories = @json($subCategory);
    const categorySelect = document.getElementById('bricks_type_category');
    const subCategorySelect = document.getElementById('bricks_type_sub_category');

    categorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

        const filteredSubCategories = subCategories.filter(
            item => item.bricks_type_category_id == selectedCategoryId
        );

        filteredSubCategories.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.bricks_type_sub_category_name;
            subCategorySelect.appendChild(option);
        });
    });
</script>
@endsection
