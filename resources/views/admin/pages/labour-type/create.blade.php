@extends('admin.include.layout')

@push('title')
    Labour Type Creation
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Labour Type</h5>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST" action="{{ route('admin.labour_type.createLabourType') }}"
                            novalidate>
                            @csrf

                            <!-- Labour Type -->
                            <div class="col-md-12">
                                <label class="form-label">Labour Type <span class="text-danger">*</span></label>
                                <input type="text" name="labour_type" class="form-control" placeholder="Enter Labour Type" value="{{ old('labour_type') }}">
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
