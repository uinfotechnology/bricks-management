@extends('admin.include.layout')

@push('title')
    Labour Payment Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Labour Payment Details</h5>
                    </div>
                    <div class="card-body">
                        {{-- Filter Form --}}
                        <form method="POST" action="{{ route('admin.labourPayment.getLabourPaymentFilter') }}"
                            class="row gy-3">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <label class="form-label">Labour Name <span class="text-danger">*</span></label>
                                    <select id="labour_id" name="labour_id" class="form-control">
                                        <option value="">Select Labour</option>
                                        @foreach ($labour as $value)
                                            <option value="{{ $value->id }}"
                                                {{ isset($selectedLabourId) && $selectedLabourId == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('labour_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">From Date <span class="text-danger">*</span></label>
                                    <input type="date" id="from_date" name="from_date" class="form-control"
                                        value="{{ $selectedFromDate ?? '' }}">
                                    @error('from_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">To Date <span class="text-danger">*</span></label>
                                    <input type="date" id="to_date" name="to_date" class="form-control"
                                        value="{{ $selectedToDate ?? '' }}">
                                    @error('to_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 33px;">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Table Result --}}
                @isset($paymentDetails)
                    <div class="card mt-4">
                        <div class="col-xxl-12">
                            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                                <div
                                    class="card-header pt-16 pb-0 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex align-items-center flex-wrap justify-content-between">
                                    <h6 class="text-lg mb-0">Filtered Payment Details</h6>
                                    <ul class="nav bordered-tab d-inline-flex nav-pills mb-0" id="pills-tab-six" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link px-16 py-10 active" id="payment-details-tab"
                                                data-bs-toggle="pill" data-bs-target="#payment-details" type="button"
                                                role="tab" aria-controls="payment-details" aria-selected="true">Payment
                                                Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link px-16 py-10" id="labour-profile-tab" data-bs-toggle="pill"
                                                data-bs-target="#labour-profile" type="button" role="tab"
                                                aria-controls="labour-profile" aria-selected="false" tabindex="-1">Labour
                                                Profile</button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-24 pt-10">
                                    <div class="tab-content" id="pills-tabContent-six">
                                        <div class="tab-pane fade show active" id="payment-details" role="tabpanel"
                                            aria-labelledby="payment-details-tab" tabindex="0">
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    @if ($paymentDetails->isEmpty())
                                                        <p class="text-danger">No records found for the selected filters.</p>
                                                    @else
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Bricks Quantity</th>
                                                                    <th>Total Payment</th>
                                                                    <th>Paid Amount</th>
                                                                    <th>Due Amount</th>
                                                                    <th>Payment Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($paymentDetails as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $item->total_bricks }}</td>
                                                                        <td>{{ $item->total_payment }}</td>
                                                                        <td>{{ number_format($item->paid_amount, 2) }}</td>
                                                                        <td>{{ number_format($item->due_amount, 2) }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($item->payment_date)->format('d-m-Y') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="labour-profile" role="tabpanel"
                                            aria-labelledby="labour-profile-tab" tabindex="0">
                                            <div class="card mt-4">
                                                <div class="card-header">
                                                    <h6 class="mb-0">Labour Profile</h6>
                                                </div>
                                                <div class="card-body">
                                                    @if ($paymentDetails->isEmpty())
                                                        <p class="text-danger">No records found for the selected filters.</p>
                                                    @else
                                                        @php
                                                            $profile = $paymentDetails->first();
                                                        @endphp
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>Image</th>
                                                                <td><img src="{{ asset('upload/labour/' . $profile->image) }}"
                                                                        alt="" style="height:50px;width:50px;">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Labour Name</th>
                                                                <td>{{ $profile->labour_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Gender</th>
                                                                <td>{{ $profile->gender }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Labour Type</th>
                                                                <td>{{ ucwords(str_replace('_', ' ', $profile->labour_type)) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mobile No</th>
                                                                <td>{{ $profile->mobile_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address</th>
                                                                <td>{{ $profile->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>City</th>
                                                                <td>{{ $profile->city }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>State</th>
                                                                <td>{{ $profile->state }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Aadhar No</th>
                                                                <td>{{ $profile->aadhar_no }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pan Number</th>
                                                                <td>{{ $profile->pan_number }}</td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
