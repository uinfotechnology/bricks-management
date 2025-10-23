@extends('admin.include.layout')

@push('title')
    Bricks Sale Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bricks Sale Details</h5>
                        <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Back</a>
                    </div>

                    <div class="card-body">
                        @if (!$getData)
                            <p class="text-danger">No records found.</p>
                        @else
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>Bill No</th>
                                        <td>{{ $getData->bill_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td>{{ $getData->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Mobile</th>
                                        <td>{{ $getData->customer_mobile }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer Address</th>
                                        <td>{{ $getData->customer_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $getData->customer_city }}</td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td>{{ $getData->customer_state }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Number</th>
                                        <td>{{ $getData->vehicle_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <td>{{ $getData->vehicle_type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bricks Type Category</th>
                                        <td>{{ $getData->bricks_type_category_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bricks Type Sub Category</th>
                                        <td>{{ $getData->bricks_type_sub_category_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Quantity</th>
                                        <td>{{ $getData->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rate (Per Thousand)</th>
                                        <td>{{ number_format($getData->rate_per_thousand, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>{{ number_format($getData->total_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Amount Received</th>
                                        <td>{{ number_format($getData->amount_received, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Due Amount</th>
                                        <td>{{ number_format($getData->due_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Mode</th>
                                        <td>{{ ucfirst($getData->payment_mode) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sale Date</th>
                                        <td>{{ \Carbon\Carbon::parse($getData->sale_date)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Financial Year</th>
                                        <td>{{ $getData->financial_year }}</td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{ $getData->remarks ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bricks Sale Slip</th>
                                        <td>
                                            @if ($getData->upload_image)
                                                <a href="{{ asset('upload/bricks-sale/' . $getData->upload_image) }}"
                                                    class="popup-img">
                                                    <img src="{{ asset('upload/bricks-sale/' . $getData->upload_image) }}"
                                                        alt="Bricks Sale Slip"
                                                        style="max-width:60px; max-height:60px; object-fit:cover;">
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ \Carbon\Carbon::parse($getData->created_at)->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
