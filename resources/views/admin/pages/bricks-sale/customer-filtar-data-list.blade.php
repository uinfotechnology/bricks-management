@extends('admin.include.layout')

@push('title')
    Customer Wise Bricks Sale Filter
@endpush

@section('layout')
<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Customer Wise Bricks Sale Filter</h5>
                    <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks Sale List</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bricks_sale.getCustomerWiseFilter') }}" class="row gy-3">
                        @csrf

                        <div class="col-md-10">
                            <label class="form-label">Select Customer <span class="text-danger">*</span></label>
                            <select name="customer_id" class="form-control" required>
                                <option value="" selected disabled>Select customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ (isset($selectedCustomer) && $selectedCustomer == $customer->id) ? 'selected' : '' }}>
                                        {{ ucfirst($customer->customer_name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Filtered Data Table --}}
            @isset($details)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filtered Bricks Sale Details</h5>
                    </div>
                    <div class="card-body">
                        @if ($details->isEmpty())
                            <p class="text-danger">No records found for the selected customer and date range.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Bill No</th>
                                        <th>Customer Name</th>
                                        <th>Bricks Type</th>
                                        <th>Bricks Sub Type</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Vehicle Number</th>
                                        <th>Sale Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->bill_no }}</td>
                                            <td>{{ $item->customer_name }}</td>
                                            <td>{{ $item->bricks_type_category_name }}</td>
                                            <td>{{ $item->bricks_type_sub_category_name ?? '' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total_amount, 2) }}</td>
                                            <td>{{ $item->vehicle_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->sale_date)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            @endisset
        </div>
    </div>
</div>
@endsection
