@extends('admin.include.layout')

@push('title')
    Labour Payment Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h6>Payment Details for {{ $labour->name }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Labour Name</p>
                                        <h6 class="mb-0">{{ $labour->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Mobile</p>
                                        <h6 class="mb-0">{{ $labour->mobile_number }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Labour Type</p>
                                        <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $labour->labour_type)) }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">City</p>
                                        <h6 class="mb-0">{{ $labour->city }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                @if ($payments->isEmpty())
                                    <p class="text-danger">No payment records found.</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Total Bricks</th>
                                                <th>Payment</th>
                                                <th>Total Payment</th>
                                                <th>Paid Amount</th>
                                                <th>Due Amount</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments as $key => $payment)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $payment->total_bricks }}</td>
                                                    <td>{{ number_format($payment->current_payment, 2) }}</td>
                                                    <td>{{ number_format($payment->total_payment, 2) }}</td>
                                                    <td>{{ number_format($payment->paid_amount, 2) }}</td>
                                                    <td>{{ number_format($payment->due_amount, 2) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
                                                    </td>
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
    </div>
@endsection
