@extends('admin.include.layout')

@push('title')
    Labour Report Summary
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h6>Report Summary for {{ $labour->name }}</h6>
                    </div>
                    <div class="card-body">

                        {{-- Labour Info Section --}}
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

                        {{-- Work & Payment Details --}}
                        <div class="row mt-4">
                            {{-- Work Details --}}
                            <div class="col-md-5 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-hammer me-2"></i>Work
                                            Details</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        @if ($workDetails->isEmpty())
                                            <p class="p-3 text-danger mb-0">No work records found.</p>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm mb-0">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th style="font-size: 12px;">SL</th>
                                                            <th style="font-size: 12px;">Bricks Quantity</th>
                                                            <th style="font-size: 12px;">Payment</th>
                                                            <th style="font-size: 12px;">Work Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($workDetails as $key => $work)
                                                            <tr>
                                                                <td style="font-size: 12px;">{{ $key + 1 }}</td>
                                                                <td style="font-size: 12px;">{{ $work->bricks_quantity }}
                                                                </td>
                                                                <td style="font-size: 12px;">
                                                                    ₹{{ number_format($work->current_payment, 2) }}</td>
                                                                <td style="font-size: 12px;">
                                                                    {{ \Carbon\Carbon::parse($work->work_date)->format('d-m-Y') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Payment Details --}}
                            <div class="col-md-7 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold text-secondary"><i class="bi bi-cash-stack me-2"></i>Payment
                                            Details</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        @if ($payments->isEmpty())
                                            <p class="p-3 text-danger mb-0">No payment records found.</p>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-sm mb-0">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th style="font-size: 12px;">SL</th>
                                                            <th style="font-size: 12px;">Total Bricks</th>
                                                            <th style="font-size: 12px;">Payment</th>
                                                            <th style="font-size: 12px;">Total Payment</th>
                                                            <th style="font-size: 12px;">Paid</th>
                                                            <th style="font-size: 12px;">Due</th>
                                                            <th style="font-size: 12px;">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($payments as $key => $payment)
                                                            <tr>
                                                                <td style="font-size: 12px;">{{ $key + 1 }}</td>
                                                                <td style="font-size: 12px;">{{ $payment->total_bricks }}
                                                                </td>
                                                                <td style="font-size: 12px;"
                                                                    class="text-primary fw-semibold">
                                                                    ₹{{ number_format($payment->current_payment, 2) }}</td>
                                                                <td style="font-size: 12px;">
                                                                    ₹{{ number_format($payment->total_payment, 2) }}</td>
                                                                <td style="font-size: 12px;"
                                                                    class="text-success fw-semibold">
                                                                    ₹{{ number_format($payment->paid_amount, 2) }}</td>
                                                                <td style="font-size: 12px;"
                                                                    class="text-danger fw-semibold">
                                                                    ₹{{ number_format($payment->due_amount, 2) }}</td>
                                                                <td style="font-size: 12px;">
                                                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Summary Section --}}
                        <div class="mt-4">
                            <div class="card border-0 shadow-sm bg-light">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold text-secondary mb-3">Overall Summary</h6>
                                    @php
                                        $totalBricks = $workDetails->sum('bricks_quantity');
                                        $totalCurrentPayment = $payments->sum('current_payment');
                                        $totalPaid = $payments->sum('paid_amount');
                                        $lastDue = $payments->isNotEmpty() ? $payments->first()->due_amount : 0;
                                    @endphp
                                    <div class="row g-3">
                                        <div class="col-md-3 col-6">
                                            <div class="p-3 bg-white shadow-sm rounded">
                                                <p class="mb-1 small text-muted">Total Bricks</p>
                                                <h6 class="mb-0 fw-bold text-dark">{{ $totalBricks }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="p-3 bg-white shadow-sm rounded">
                                                <p class="mb-1 small text-muted">Total Payment</p>
                                                <h6 class="mb-0 fw-bold text-primary">
                                                    ₹{{ number_format($totalCurrentPayment, 2) }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="p-3 bg-white shadow-sm rounded">
                                                <p class="mb-1 small text-muted">Total Paid</p>
                                                <h6 class="mb-0 fw-bold text-success">₹{{ number_format($totalPaid, 2) }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="p-3 bg-white shadow-sm rounded">
                                                <p class="mb-1 small text-muted">Last Due Amount</p>
                                                <h6 class="mb-0 fw-bold text-danger">₹{{ number_format($lastDue, 2) }}</h6>
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

    {{-- Custom CSS for table --}}
    <style>
        table.table-sm th,
        table.table-sm td {
            font-size: 14px;
            padding: 0.6rem 0.8rem;
            white-space: normal;
        }

        .card p,
        .card h6 {
            font-size: 14px;
        }

        .card-body.text-center h6 {
            font-size: 16px;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>

@endsection
