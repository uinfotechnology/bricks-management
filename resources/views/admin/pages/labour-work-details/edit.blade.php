@extends('admin.include.layout')

@push('title')
    Labour Work Update
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Labour Work</h5>
                        <div>
                            <a href="{{ route('admin.labourWorkDetails.labourWorkDetailsList') }}"
                                class="btn btn-sm btn-primary">Labour Work List</a>
                        </div>
                    </div>
                    <div class="card-body">
                            <form class="row gy-3 needs-validation" method="POST"
                                action="{{ route('admin.labourWorkDetails.updatelabourWorkDetails', Crypt::encrypt($labour->id)) }}" novalidate
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Labour Name -->
                                <div class="col-md-3">
                                    <label class="form-label">Labour Name <span class="text-danger">*</span></label>
                                    <select name="labour_id" id="labourSelect" class="form-control">
                                        <option value="">Select Labour Name</option>
                                        @foreach ($list as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $labour->labour_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('labour_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bricks Quantity -->
                                <div class="col-md-3">
                                    <label class="form-label">Bricks Quantity <span class="text-danger">*</span></label>
                                    <input type="text" name="bricks_quantity" class="form-control"
                                        value="{{ old('bricks_quantity', $labour->bricks_quantity) }}">
                                    @error('bricks_quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Date -->
                                <div class="col-md-2">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ old('date', $labour->work_date) }}">
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-4">
                                    <label class="form-label">Remarks</label>
                                    <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                        value="{{ old('remarks', $labour->remarks) }}">
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary-600" type="submit">Update</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
