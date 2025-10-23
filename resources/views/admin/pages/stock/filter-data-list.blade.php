@extends('admin.include.layout')

@push('title')
    Stock Use Details
@endpush

@section('layout')
<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">

            {{-- Filter Form --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Filter Stock Use</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.stock.getUseStockFilter') }}" class="row gy-3">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-control">
                                <option value="">Select Product</option>
                                @foreach ($getProduct as $value)
                                    <option value="{{ $value->id }}"
                                        {{ (isset($selectedProductId) && $selectedProductId == $value->id) ? 'selected' : '' }}>
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
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $selectedFromDate ?? '' }}">
                            @error('from_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $selectedToDate ?? '' }}">
                            @error('to_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" style="margin-top: 33px;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Result --}}
            @isset($useStockDetails)
                <div class="card mt-4">
                    <div class="card-body">
                        @if ($useStockDetails->isEmpty())
                            <p class="text-danger">No records found for the selected filters.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($useStockDetails as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ number_format($item->quantity, 2) }}</td>
                                            <td>{{ ucfirst($item->unit) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                            <td>{{ $item->remarks }}</td>
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
