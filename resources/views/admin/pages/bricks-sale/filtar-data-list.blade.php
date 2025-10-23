@extends('admin.include.layout')

@push('title')
    Bricks Sale Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Bricks Sale Details</h5>
                        <div>
                            <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks
                                Sale List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.bricks_sale.getBricksSaleFilter') }}" class="row gy-3">
                            @csrf
                            <div class="col-md-5">
                                <label class="form-label">From Date <span class="text-danger">*</span></label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ $selectedFromDate ?? '' }}">
                                @error('from_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">To Date <span class="text-danger">*</span></label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ $selectedToDate ?? '' }}">
                                @error('to_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                @isset($details)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filter Bricks Sale Details</h5>
                        </div>
                        <div class="card-body">
                            @if ($details->isEmpty())
                                <p class="text-danger">No records found for the selected date range.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Bill No</th>
                                            <th>Customer Name</th>
                                            <th>Quantity</th>
                                            <th>Bricks Type</th>
                                            <th>Bricks Type</th>
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
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->bricks_type_category_name }}</td>
                                                <td>{{ $item->bricks_type_sub_category_name ?? '' }}</td>
                                                <td>{{ $item->total_amount }}</td>
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
