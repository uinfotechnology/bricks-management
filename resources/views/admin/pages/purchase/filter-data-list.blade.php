@extends('admin.include.layout')

@push('title')
    Purchase Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Purchase Details</h5>
                    </div>
                    <div class="card-body">
                        {{-- Filter Form --}}
                        <form method="POST" action="{{ route('admin.purchase.getPurchaseFilter') }}" class="row gy-3">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <select id="product_id" name="product_id" class="form-control">
                                        <option value="">Select Product</option>
                                        @foreach ($getProduct as $value)
                                            <option value="{{ $value->id }}"
                                                {{ isset($selectedProductId) && $selectedProductId == $value->id ? 'selected' : '' }}>
                                                {{ $value->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
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
                @isset($purchaseDetails)
                    <div class="card mt-4">
                        <div class="col-xxl-12">
                            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                                <div
                                    class="card-header pt-16 pb-0 px-24 bg-base border d-flex align-items-center flex-wrap justify-content-between">
                                    <h6 class="text-lg mb-0">Filtered Purchase Details</h6>
                                    <ul class="nav bordered-tab d-inline-flex nav-pills mb-0" id="pills-tab-six" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link px-16 py-10 active" id="purchase-details-tab"
                                                data-bs-toggle="pill" data-bs-target="#purchase-details" type="button"
                                                role="tab" aria-controls="purchase-details" aria-selected="true">
                                                Purchase Details
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link px-16 py-10" id="account-profile-tab" data-bs-toggle="pill"
                                                data-bs-target="#account-profile" type="button" role="tab"
                                                aria-controls="account-profile" aria-selected="false">
                                                Company Profile
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body p-24 pt-10">
                                    <div class="tab-content" id="pills-tabContent-six">
                                        {{-- Purchase Table --}}
                                        <div class="tab-pane fade show active" id="purchase-details" role="tabpanel"
                                            aria-labelledby="purchase-details-tab" tabindex="0">
                                            <div class="card mt-4">
                                                <div class="card-body">
                                                    @if ($purchaseDetails->isEmpty())
                                                        <p class="text-danger">No records found for the selected filters.</p>
                                                    @else
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Bill No</th>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Rate</th>
                                                                    <th>Total Amount</th>
                                                                    <th>Payment Status</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($purchaseDetails as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $item->bill_no }}</td>
                                                                        <td>{{ $item->product_name }}</td>
                                                                        <td>{{ number_format($item->quantity, 2) }}
                                                                            {{ ucfirst($item->unit) }}</td>
                                                                        <td>{{ $item->rate }}</td>
                                                                        <td>{{ $item->total_amount }}</td>
                                                                        <td>{{ ucfirst($item->payment_status) }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Company/Account Profile --}}
                                        <div class="tab-pane fade" id="account-profile" role="tabpanel"
                                            aria-labelledby="account-profile-tab" tabindex="0">
                                            <div class="card mt-4">
                                                <div class="card-header">
                                                    <h6 class="mb-0">Company Profile</h6>
                                                </div>
                                                <div class="card-body">
                                                    @if ($purchaseDetails->isEmpty())
                                                        <p class="text-danger">No records found for the selected filters.</p>
                                                    @else
                                                        @php
                                                            $profile = $purchaseDetails->first();
                                                        @endphp
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>Party Name</th>
                                                                <td>{{ $profile->party_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Contact Person</th>
                                                                <td>{{ $profile->contact_person }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Mobile No</th>
                                                                <td>{{ $profile->mobile_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Secondary Mobile</th>
                                                                <td>{{ $profile->secondary_mobile_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>GST No</th>
                                                                <td>{{ $profile->gst_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>PAN No</th>
                                                                <td>{{ $profile->pan_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Opening Balance</th>
                                                                <td>{{ $profile->opening_balance }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Address</th>
                                                                <td>{{ $profile->address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bank Name</th>
                                                                <td>{{ $profile->bank_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Account Number</th>
                                                                <td>{{ $profile->account_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>IFSC Code</th>
                                                                <td>{{ $profile->ifsc_code }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Account Holder</th>
                                                                <td>{{ $profile->account_holder_name }}</td>
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
