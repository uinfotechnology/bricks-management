@extends('admin.include.layout')

@push('title')
    Bricks Type Sub Category List
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/responsive.dataTables.min.css') }}">
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Bricks Type Sub Category</h5>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_type_sub_category.storeBricksTypeSubCategory') }}" novalidate>
                            @csrf

                            <div class="col-md-6">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span> </label>
                                <select name="bricks_type_category_id" class="form-control" required>
                                    <option value="">Select Bricks Type Category</option>
                                    @foreach ($category as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('bricks_type_category_id') == $value->id ? 'selected' : '' }}>
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
                                    placeholder="Enter Bricks Type Sub Category"
                                    value="{{ old('bricks_type_sub_category_name') }}" required>
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

        <div class="row gy-4 mt-1">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Bricks Type Sub Category List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table striped-table mb-0 bricks-type-sub-category-table">
                                <thead>
                                    <tr>
                                        <th scope="col">SI</th>
                                        <th scope="col">Bricks Type Category Name</th>
                                        <th scope="col">Bricks Type Sub Category Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Datatables Core -->
    <script src="{{ asset('assets/js/lib/datatable/js/jquery.dataTables.min.js') }}"></script>

    <!-- Buttons -->
    <script src="{{ asset('assets/js/lib/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.print.min.js') }}"></script>
    <!-- Responsive -->
    <script src="{{ asset('assets/js/lib/datatable/js/dataTables.responsive.min.js') }}"></script>

    <!-- Excel & PDF dependencies -->
    <script src="{{ asset('assets/js/lib/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/vfs_fonts.js') }}"></script>

    <script>
        var bricksTypeSubCategoryList = "{{ route('admin.bricks_type_sub_category.bricksTypeSubCategoryList') }}";
    </script>
    <script src="{{ asset('assets/js/datatable.init.js') }}"></script>
@endpush
