@extends('admin.include.layout')

@push('title')
    Vehicle Payment
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Vehicle Payment</h5>
                        <div>
                            <a href="{{ route('admin.vehicle.vehicleList') }}" class="btn btn-sm btn-primary">Vehicle List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">

                            <div class="row g-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Vehicle Name</p>
                                        <h6 class="mb-0">{{ $vehicle->vehicle_name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Vehicle Number</p>
                                        <h6 class="mb-0">{{ $vehicle->vehicle_number }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Owner Name</p>
                                        <h6 class="mb-0">{{ $vehicle->ownar_name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Contact No</p>
                                        <h6 class="mb-0">{{ $vehicle->contact_no }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="row gy-3 needs-validation mt-3" method="POST"
                            action="{{ route('admin.vehicle.storeVehiclePayment', Crypt::encrypt($vehicle->id)) }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Rent Amount -->
                            <div class="col-md-4">
                                <label class="form-label">Rent Amount </label>
                                <input type="number" name="rent_amount" class="form-control"
                                    value="{{ old('rent_amount', $vehicle->rent_amount) }}" readonly>
                                @error('rent_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Paid Amount -->
                            <div class="col-md-4">
                                <label class="form-label">Paid Amount <span class="text-danger">*</span></label>
                                <input type="number" name="paid_amount" class="form-control"
                                    value="{{ old('paid_amount', $vehicle->rent_amount) }}" step="0.01" placeholder="Enter Paid Amount" readonly>
                                @error('paid_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="col-md-4">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}">
                                @error('payment_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                    value="{{ old('remarks') }}">
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit"> Payment</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
