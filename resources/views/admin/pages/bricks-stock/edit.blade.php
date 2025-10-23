@extends('admin.include.layout')

@push('title')
    Bricks Stock
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Edit Bricks Stock</h5>
                        <div>
                            <a href="{{ route('admin.bricks_stock.BricksStockList') }}" class="btn btn-sm btn-primary">
                                Bricks Stock List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_stock.updateBricksStock', Crypt::encrypt($data->id)) }}"
                            novalidate>
                            @csrf

                            <!-- Bricks Quantity -->
                            <div class="col-md-3">
                                <label class="form-label">Bricks Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="bricks_quantity" class="form-control"
                                    value="{{ $data->bricks_quantity }}" min="1">
                                @error('bricks_quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bricks Type Category -->
                            <div class="col-md-3">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span></label>
                                <select id="bricks_type_category" name="bricks_type_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}"
                                            {{ $data->bricks_type_category_id == $value->id ? 'selected' : '' }}>
                                            {{ $value->bricks_type_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bricks_type_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bricks Type Sub Category -->
                            <div class="col-md-3">
                                <label class="form-label">Bricks Type Sub Category</label>
                                <select id="bricks_type_sub_category" name="bricks_type_sub_category_id"
                                    class="form-control">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subCategory as $sub)
                                        @if ($sub->bricks_type_category_id == $data->bricks_type_category_id)
                                            <option value="{{ $sub->id }}"
                                                {{ $data->bricks_type_sub_category_id == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->bricks_type_sub_category_name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('bricks_type_sub_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="col-md-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ $data->stock_date }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Update Stock</button>
                            </div>
                        </form>
                    </div>
                </div>
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
