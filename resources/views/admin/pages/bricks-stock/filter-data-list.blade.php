@extends('admin.include.layout')

@push('title')
    Bricks Stock Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">

                {{-- Filter Form --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter Bricks Stock</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.bricks_stock.getBricksStockFilter') }}" class="row gy-3">
                            @csrf

                            <div class="col-md-3">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span></label>
                                <select id="bricks_type_category" name="bricks_type_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}"
                                            {{ isset($selectedCategory) && $selectedCategory == $value->id ? 'selected' : '' }}>
                                            {{ $value->bricks_type_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bricks_type_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Bricks Type Sub Category</label>
                                <select id="bricks_type_sub_category" name="bricks_type_sub_category_id"
                                    class="form-control">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">From Date <span class="text-danger">*</span></label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ $selectedFromDate ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">To Date <span class="text-danger">*</span></label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ $selectedToDate ?? '' }}">
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Table Result --}}
                @if (isset($selectedCategory) || isset($selectedFromDate) || isset($selectedToDate))
                    <div class="card mt-4">
                        <div class="card-body">
                            @if ($getData->isEmpty())
                                <p class="text-danger">No records found for the selected filters.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getData as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->bricks_type_category_name }}</td>
                                                <td>{{ $item->bricks_type_sub_category_name ?? '-' }}</td>
                                                <td>{{ $item->bricks_quantity }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->stock_date)->format('d-m-Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script>
        const subCategories = @json($subCategory);
        const selectedSubCat = "{{ $selectedSubCategory ?? '' }}";
        const categorySelect = document.getElementById('bricks_type_category');
        const subCategorySelect = document.getElementById('bricks_type_sub_category');

        function populateSubCategories(categoryId) {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            const filtered = subCategories.filter(item => item.bricks_type_category_id == categoryId);
            filtered.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.bricks_type_sub_category_name;
                if (item.id == selectedSubCat) option.selected = true;
                subCategorySelect.appendChild(option);
            });
        }

        categorySelect.addEventListener('change', function() {
            populateSubCategories(this.value);
        });

        // Auto load if selectedCategory exists
        if (categorySelect.value) {
            populateSubCategories(categorySelect.value);
        }
    </script>
@endsection
