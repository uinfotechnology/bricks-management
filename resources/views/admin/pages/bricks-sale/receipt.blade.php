@extends('admin.include.layout')

@push('title')
    Payment Receipt
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Payment Receipt - Bill No: {{ $sale->bill_no }}</h5>
                        <div>
                            <a href="javascript:void(0)"
                                class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1">
                                <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                                Download
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                                onclick="printInvoice()">
                                <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                                Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body py-40" id="printSection">
                        <div class="row justify-content-center" id="invoice">
                            <div class="col-lg-8">
                                <div class="shadow-4 border radius-8">
                                    <!-- Header -->
                                    <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                        <div>
                                            <h3 class="text-xl">Invoice #{{ $sale->bill_no }}</h3>
                                            <p class="mb-1">Date Issued:
                                                {{ $sale->sale_date ? date('d-m-Y', strtotime($sale->sale_date)) : '' }}</p>
                                            <p class="mb-0">Financial Year: {{ $sale->financial_year }}</p>
                                        </div>
                                        <div>
                                            <img src="{{ asset('upload/company/' . $companyDetails->image) }}"
                                                alt="Company Logo" style="height:40px;width:180px;">
                                            <p class="mb-1">{{ $companyDetails->address }}, {{ $companyDetails->city }},
                                                {{ $companyDetails->state }}</p>
                                            <p class="mb-0">Mobile: {{ $companyDetails->phone }}</p>
                                        </div>
                                    </div>

                                    <div class="py-28 px-20">
                                        <!-- Party Details -->
                                        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                                            <div>
                                                <h6 class="text-md">Issued For:</h6>
                                                <table class="text-sm text-secondary-light">
                                                    <tbody>
                                                        <tr>
                                                            <td>Customer Name</td>
                                                            <td class="ps-8">: {{ $sale->customer_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile No</td>
                                                            <td class="ps-8">: {{ $sale->customer_mobile }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address</td>
                                                            <td class="ps-8">: {{ $sale->customer_address }},
                                                                {{ $sale->customer_city }},
                                                                {{ $sale->customer_state }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Vehicle</td>
                                                            <td class="ps-8">:
                                                                {{ ucfirst($sale->vehicle_type ?? '-') }}
                                                                ({{ $sale->vehicle_number ?? '-' }})</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Product Details Table -->
                                        <div class="mt-24">
                                            <div class="table-responsive scroll-sm">
                                                <table class="table bordered-table text-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Bricks Type</th>
                                                            <th>Bricks Type</th>
                                                            <th>Qty</th>
                                                            <th>Rate</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $sale->bricks_type_category_name ?? '-' }}</td>
                                                            <td>{{ $sale->bricks_type_sub_category_name ?? '-' }}</td>
                                                            <td>{{ $sale->quantity }}</td>
                                                            <td>₹{{ $sale->rate_per_thousand }}/-</td>
                                                            <td>₹{{ $sale->total_amount }}/-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Payment Summary -->
                                            <div class="d-flex flex-wrap justify-content-between gap-3 mt-3">
                                                <div>
                                                    <p class="mb-0"><strong>Sales By:</strong>
                                                        {{ $companyDetails->company_name }}</p>
                                                    <p class="mb-0">Thanks for your business!</p>
                                                </div>
                                                <div>
                                                    <table class="text-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pe-64">Total Amount:</td>
                                                                <td class="pe-16">
                                                                    <span
                                                                        class="text-primary-light fw-semibold">₹{{ $sale->total_amount }}/-</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pe-64">Amount Received:</td>
                                                                <td class="pe-16">
                                                                    <span
                                                                        class="text-primary-light fw-semibold">₹{{ $sale->amount_received }}/-</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pe-64">Due Amount:</td>
                                                                <td class="pe-16">
                                                                    <span
                                                                        class="text-primary-light fw-semibold">₹{{ $sale->due_amount }}/-</span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="pe-64">Payment Mode:</td>
                                                                <td class="pe-16">
                                                                    {{ ucfirst($sale->payment_mode) ?? 'N/A' }}
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-64">
                                            <p class="text-center text-secondary-light text-sm fw-semibold">Thank you for
                                                your purchase!</p>
                                        </div>

                                        <div class="d-flex flex-wrap justify-content-between align-items-end mt-64">
                                            <div class="text-sm border-top d-inline-block px-12">Signature of Customer
                                            </div>
                                            <div class="text-sm border-top d-inline-block px-12">Signature of Authorized
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Print Script --}}
    <script>
        function printInvoice() {
            var printContents = document.getElementById("printSection").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // reload page after print to restore events
        }
    </script>
@endsection
