@extends('admin.include.layout')
@push('title')
    Labour Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">View Profile</h6>
        </div>

        <div class="row gy-4">
            <!-- Profile Section -->
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png') }}" alt=""
                        class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16 mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="{{ asset('upload/labour/' . $labour->image) }}" alt="Profile Image"
                                class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover mb-16">
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-40 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-60 text-secondary-light fw-medium">: {{ $labour->name }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-40 text-md fw-semibold text-primary-light">Mobile</span>
                                    <span class="w-60 text-secondary-light fw-medium">:
                                        +91-{{ $labour->mobile_number }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-40 text-md fw-semibold text-primary-light">Alternate Mobile</span>
                                    <span class="w-60 text-secondary-light fw-medium">:
                                        +91-{{ $labour->secondary_mobile_number }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-40 text-md fw-semibold text-primary-light">Date of Birth</span>
                                    <span class="w-60 text-secondary-light fw-medium">:
                                        {{ $labour->dob ? \Carbon\Carbon::parse($labour->dob)->format('d-m-Y') : 'N/A' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-40 text-md fw-semibold text-primary-light">Gender</span>
                                    <span class="w-60 text-secondary-light fw-medium">: {{ $labour->gender }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Labour Details Section -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6 class="mb-0">Labour Details</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Labour Type</th>
                                        <td>{{ ucfirst(str_replace('_', ' ', $labour->labour_type)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rate Per Thousand</th>
                                        <td>{{ $labour->rate_per_thousand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Aadhar</th>
                                        <td>{{ $labour->aadhar_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>PAN</th>
                                        <td>{{ $labour->pan_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $labour->city }}</td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>{{ $labour->state }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $labour->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{ $labour->remarks ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $labour->created_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
