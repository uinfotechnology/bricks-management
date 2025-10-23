@extends('admin.include.layout')

@push('title')
    Payment Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                @isset($accountDetails)
                    <div class="card mt-4">
                        <div
                            class="card-header pt-16 pb-0 px-24 bg-base border d-flex align-items-center flex-wrap justify-content-between">
                            <h6 class="text-lg mb-0">Payment Details for {{ $accountDetails->party_name }}</h6>
                            <ul class="nav bordered-tab d-inline-flex nav-pills mb-0" id="pills-tab-six" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link px-16 py-10 active" id="payment-details-tab" data-bs-toggle="pill"
                                        data-bs-target="#payment-details" type="button" role="tab"
                                        aria-controls="payment-details" aria-selected="true">
                                        Payment Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link px-16 py-10" id="purchase-details-tab" data-bs-toggle="pill"
                                        data-bs-target="#purchase-details" type="button" role="tab"
                                        aria-controls="purchase-details" aria-selected="false">
                                        Purchase Details
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body p-24 pt-10">
                            <!-- Account Details -->
                            <div class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card p-3 border h-100">
                                            <p class="mb-1 text-muted small">Party Name</p>
                                            <h6 class="mb-0">{{ $accountDetails->party_name ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card p-3 border h-100">
                                            <p class="mb-1 text-muted small">Contact Person</p>
                                            <h6 class="mb-0">{{ $accountDetails->contact_person ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card p-3 border h-100">
                                            <p class="mb-1 text-muted small">Mobile</p>
                                            <h6 class="mb-0">{{ $accountDetails->mobile_number ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card p-3 border h-100">
                                            <p class="mb-1 text-muted small">Product</p>
                                            <h6 class="mb-0">{{ $accountDetails->product_name ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-content" id="pills-tabContent-six">

                                <!-- Payment Table -->
                                <div class="tab-pane fade show active" id="payment-details" role="tabpanel"
                                    aria-labelledby="payment-details-tab" tabindex="0">
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            @if ($payments->isEmpty())
                                                <p class="text-danger">No payment details found.</p>
                                            @else
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Bill No</th>
                                                            <th>Amount Paid</th>
                                                            <th>Due Amount</th>
                                                            <th>Total Amount</th>
                                                            <th>Payment Status</th>
                                                            <th>Payment Mode</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($payments as $key => $payment)
                                                            @php
                                                                $purchase = $purchases->firstWhere('id', $payment->purchase_id);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $purchase ? $purchase->bill_no : 'N/A' }}</td>
                                                                <td>{{ number_format($payment->amount_paid, 2) }}</td>
                                                                <td>{{ number_format($payment->due_amount, 2) }}</td>
                                                                <td>{{ number_format($payment->total_amount, 2) }}</td>
                                                                <td
                                                                    class="{{ $payment->payment_status == 'paid' ? 'text-success' : 'text-danger' }}">
                                                                    <b>{{ ucfirst($payment->payment_status) }}</b>
                                                                </td>
                                                                <td>{{ ucfirst($payment->payment_mode) }}</td>
                                                                <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') : 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Purchase Table -->
                                <div class="tab-pane fade" id="purchase-details" role="tabpanel"
                                    aria-labelledby="purchase-details-tab" tabindex="0">
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            @if ($purchases->isEmpty())
                                                <p class="text-danger">No purchase details found.</p>
                                            @else
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Bill No</th>
                                                            <th>Product</th>
                                                            <th>Quantity</th>
                                                            <th>Rate</th>
                                                            <th>Discount</th>
                                                            <th>GST</th>
                                                            <th>Total Amount</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($purchases as $key => $purchase)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $purchase->bill_no ?? 'N/A' }}</td>
                                                                <td>{{ $purchase->product_name ?? 'N/A' }}</td>
                                                                <td>{{ number_format($purchase->quantity, 2) }} {{ ucfirst($purchase->unit ?? 'N/A') }}</td>
                                                                <td>{{ number_format($purchase->rate, 2) }}</td>
                                                                <td>{{ number_format($purchase->discount, 2) }}</td>
                                                                <td>{{ $purchase->gst ?? 'N/A' }}</td>
                                                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                                                <td>{{ $purchase->date ? \Carbon\Carbon::parse($purchase->date)->format('d-m-Y') : 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-danger">No account details found.</p>
                @endisset
            </div>
        </div>
    </div>
@endsection