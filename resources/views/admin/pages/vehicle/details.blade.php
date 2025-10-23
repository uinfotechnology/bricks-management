@extends('admin.include.layout')

@push('title')
    Vehicle Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                {{-- Table Result --}}
                @isset($vehicle)
                    <div class="card mt-4">
                        <div class="col-xxl-12">
                            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                                <div class="card-body p-24 pt-10">

                                    {{-- Vehicle Details --}}
                                    <div class="card mt-4">
                                        <div class="card-header d-flex justify-content-between">
                                            <h6 class="mb-0">Vehicle Details</h6>
                                            <div>
                                                <a href="{{ route('admin.vehicle.vehicleList') }}"
                                                    class="btn btn-sm btn-primary">Vehicle List </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if (!$vehicle)
                                                <p class="text-danger">No records found.</p>
                                            @else
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Vehicle Type</th>
                                                        <td>{{ ucwords(strtolower($vehicle->vehicle_type)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vehicle Name</th>
                                                        <td>{{ $vehicle->vehicle_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vehicle Number</th>
                                                        <td>{{ $vehicle->vehicle_number }}</td>
                                                    </tr>
                                                    @if (strtolower($vehicle->vehicle_type) == 'rent')
                                                        <tr>
                                                            <th>Rent Amount</th>
                                                            <td>{{ $vehicle->rent_amount }}</td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th>Ownar Name</th>
                                                        <td>{{ $vehicle->ownar_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact No</th>
                                                        <td>{{ $vehicle->contact_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ $vehicle->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>City</th>
                                                        <td>{{ $vehicle->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>State</th>
                                                        <td>{{ $vehicle->state }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Aadhar Card</th>
                                                        <td>
                                                            @if ($vehicle->aadhar_card)
                                                                <a href="{{ asset('upload/vehicle/' . $vehicle->aadhar_card) }}"
                                                                    class="popup-img">
                                                                    <img src="{{ asset('upload/vehicle/' . $vehicle->aadhar_card) }}"
                                                                        alt="Aadhar Card"
                                                                        style="max-width:60px; max-height:60px; object-fit:cover;">
                                                                </a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Vehicle Document</th>
                                                        <td>
                                                            @if ($vehicle->vehicle_document)
                                                                <a href="{{ asset('upload/vehicle/' . $vehicle->vehicle_document) }}"
                                                                    class="popup-img">
                                                                    <img src="{{ asset('upload/vehicle/' . $vehicle->vehicle_document) }}"
                                                                        alt="Vehicle Document"
                                                                        style="max-width:60px; max-height:60px; object-fit:cover;">
                                                                </a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Remark</th>
                                                        <td>{{ $vehicle->remarks }}</td>
                                                    </tr>

                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- End Vehicle Details --}}

                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
