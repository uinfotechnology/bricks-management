@extends('admin.include.layout')

@push('title')
    Update Bricks Type Sub Category
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Bricks Type Sub Category</h5>
                        <div>
                            <a href="{{ route('admin.bricks_type_sub_category.bricksTypeSubCategoryList') }}"
                                class="btn btn-sm btn-primary">Bricks Type Sub Category List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_type_sub_category.updateBricksTypeSubCategory', Crypt::encrypt($data->id)) }}"
                            novalidate>
                            @csrf

                            <div class="col-md-6">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span> </label>
                                <select name="bricks_type_category_id" class="form-control" required>
                                    <option value="">Select Bricks Type Category</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('bricks_type_category_id', $data->bricks_type_category_id) == $value->id ? 'selected' : '' }}>
                                            {{ $value->bricks_type_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bricks_type_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Bricks Type Sub Category <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="bricks_type_sub_category_name" class="form-control"
                                    value="{{ old('bricks_type_sub_category_name', $data->bricks_type_sub_category_name) }}">
                                @error('bricks_type_sub_category_name')
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
