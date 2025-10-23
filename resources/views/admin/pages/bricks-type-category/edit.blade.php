@extends('admin.include.layout')

@push('title')
    Update Bricks Type Category
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Bricks Type Category</h5>
                        <div>
                            <a href="{{ route('admin.bricks_type_category.bricksTypeCategoryList') }}" class="btn btn-sm btn-primary">Bricks Type Category List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_type_category.updateBricksTypeCategory', Crypt::encrypt($data->id)) }}" novalidate>
                            @csrf

                            <!-- Bricks Type Category -->
                            <div class="col-md-12">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span></label>
                                <input type="text" name="bricks_type_category_name" class="form-control"
                                    value="{{ old('bricks_type_category_name', $data->bricks_type_category_name) }}">
                                @error('bricks_type_category_name')
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
