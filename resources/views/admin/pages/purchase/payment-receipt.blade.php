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
                        <h5 class="card-title mb-0">Payment Receipt - Bill No: {{ $purchase->bill_no }}</h5>
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
                                            <h3 class="text-xl">Invoice #{{ $purchase->bill_no }}</h3>
                                            <p class="mb-1 text-sm">Date Issued:
                                                {{ $purchase->last_payment_date ? date('d-m-Y', strtotime($purchase->last_payment_date)) : '' }}
                                            </p>
                                            <p class="mb-1 text-sm">Purchase Date:
                                                {{ $purchase->date ? date('d-m-Y', strtotime($purchase->date)) : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <img src="{{ asset('upload/company') }}/{{ $companyDetsils->image }}" alt="image" class="mb-8" style="height:40px;width:180px;">
                                            <p class="mb-1 text-sm">{{ $companyDetsils->address }}, {{ $companyDetsils->city }}, {{ $companyDetsils->state }}</p>
                                            <p class="mb-0 text-sm">Mobile No - {{ $companyDetsils->phone }}</p>
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
                                                            <td>Party Name</td>
                                                            <td class="ps-8">: {{ $purchase->party_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Name</td>
                                                            <td class="ps-8">: {{ $purchase->contact_person }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Mobile No</td>
                                                            <td class="ps-8">: {{ $purchase->mobile_number }}</td>
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
                                                            <th scope="col" class="text-sm">Product</th>
                                                            <th scope="col" class="text-sm">Qty</th>
                                                            <th scope="col" class="text-sm">Unit</th>
                                                            <th scope="col" class="text-sm">Rate</th>
                                                            <th scope="col" class="text-sm">Discount</th>
                                                            <th scope="col" class="text-sm">GST</th>
                                                            <th scope="col" class="text-end text-sm">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ $purchase->product_name }}</td>
                                                            <td>{{ $purchase->quantity }}</td>
                                                            <td>{{ ucwords($purchase->unit) }}</td>
                                                            <td>₹{{ $purchase->rate }}/-</td>
                                                            <td>{{ $purchase->discount }}</td>
                                                            <td>{{ $purchase->gst }}%</td>
                                                            <td class="text-end">₹{{ $purchase->purchase_total }}/-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Payment Summary -->
                                            <div class="d-flex flex-wrap justify-content-between gap-3 mt-3">
                                                <div>
                                                    <p class="text-sm mb-0"><span
                                                            class="text-primary-light fw-semibold">Sales
                                                            By:</span> {{ $companyDetsils->company_name }}
                                                    </p>
                                                    <p class="text-sm mb-0">Thanks for your business</p>
                                                </div>
                                                <div>
                                                    <table class="text-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pe-64">Total Paid:</td>
                                                                <td class="pe-16">
                                                                    <span
                                                                        class="text-primary-light fw-semibold">₹{{ $purchase->total_paid }}/-</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pe-64">Due Amount:</td>
                                                                <td class="pe-16">
                                                                    <span
                                                                        class="text-primary-light fw-semibold">₹{{ $purchase->due_amount }}/-</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pe-64">Last Payment Date:</td>
                                                                <td class="pe-16">
                                                                    {{ $purchase->last_payment_date ? date('d-m-Y', strtotime($purchase->last_payment_date)) : '' }}
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td class="pe-64">Payment Mode:</td>
                                                                <td class="pe-16">
                                                                    {{ ucfirst($purchase->last_payment_mode ?? 'N/A') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pe-64 pt-4">
                                                                    <span class="text-primary-light fw-semibold">Payment
                                                                        Status:</span>
                                                                </td>
                                                                <td class="pe-16 pt-4">
                                                                    <span
                                                                        style="color: {{ $purchase->due_amount > 0 ? 'red' : 'green' }};">
                                                                        {{ ucwords($purchase->purchase_payment_status) }}
                                                                    </span>
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
