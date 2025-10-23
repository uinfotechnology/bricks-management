@extends('admin.include.layout')

@push('title')
    Update Labour Type
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Labour Type</h5>
                        <div>
                            <a href="{{ route('admin.labour_type.labourTypeList') }}" class="btn btn-sm btn-primary">Labour Type List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.labour_type.updateLabourType', Crypt::encrypt($product->id)) }}" novalidate>
                            @csrf

                            <!-- Product -->
                            <div class="col-md-12">
                                <label class="form-label">Labour Type <span class="text-danger">*</span></label>
                                <input type="text" name="labour_type" class="form-control" placeholder="Enter Labour Type"
                                    value="{{ old('labour_type', $product->labour_type) }}">
                                @error('labour_type')
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
