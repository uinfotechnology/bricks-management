@extends('admin.include.layout')

@push('title')
    Vehicle Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">

                {{-- Filter Form --}}
                <div class="card">
                       <div class="card-header d-flex justify-content-between">
                          <h5 class="card-title mb-0">Filter Vehicle Payment</h5>
                        <div>
                            <a href="{{ route('admin.vehicle.vehicleList') }}" class="btn btn-sm btn-primary">Vehicle List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.vehicle.getVehiclePaymentFilter') }}" class="row gy-3">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                                <select name="vehicle_id" class="form-control">
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ isset($selectedVehicle) && $selectedVehicle == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->vehicle_name }} ( {{ $vehicle->vehicle_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">From Date <span class="text-danger">*</span></label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ $selectedFromDate ?? '' }}">
                                @error('from_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">To Date <span class="text-danger">*</span></label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ $selectedToDate ?? '' }}">
                                @error('to_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Table Result --}}
                @if (isset($payments))
                    <div class="card mt-4">
                        <div class="card-body">
                            @if ($payments->isEmpty())
                                <p class="text-danger">No records found for the selected filters.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Vehicle</th>
                                            <th>Vehicle Number</th>
                                            <th>Rent Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Payment Date</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $payment)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $payment->vehicle_name }}</td>
                                                <td>{{ $payment->vehicle_number }}</td>
                                                <td>{{ $payment->rent_amount }}</td>
                                                <td>{{ $payment->paid_amount }}</td>
                                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $payment->remarks ?? '-' }}</td>
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
@endsection
