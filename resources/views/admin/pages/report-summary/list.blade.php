@extends('admin.include.layout')

@push('title')
    Comprehensive Report Summary
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="container-fluid">
          <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0"> Report Summary</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.report_summary.getReportSummary') }}" class="row gy-3">
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

            @isset($data)
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-semibold">Summary Report ({{ $selectedFromDate }} to
                            {{ $selectedToDate }})</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Summary Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-2 small text-muted">Total Account Balance</p>
                                        <h5 class="mb-0 fw-bold text-primary">
                                            ₹{{ number_format($data['account_balances']->sum('amount'), 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-2 small text-muted">Total Sales Amount</p>
                                        <h5 class="mb-0 fw-bold text-success">
                                            ₹{{ number_format($data['bricks_sales']->sum('total_amount'), 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-2 small text-muted">Total Expenses</p>
                                        <h5 class="mb-0 fw-bold text-danger">
                                            ₹{{ number_format($data['expenses']->sum('amount_spent'), 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-2 small text-muted">Total Labour Payments</p>
                                        <h5 class="mb-0 fw-bold text-info">
                                            ₹{{ number_format($data['labour_payments']->sum('paid_amount'), 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Summaries -->
                        <div class="accordion" id="reportAccordion">
                            <!-- Expenses Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#expensesCollapse" aria-expanded="false"
                                        aria-controls="expensesCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-wallet me-2"></i> Expenses
                                        </span>
                                    </button>
                                </h2>
                                <div id="expensesCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['expenses']->isEmpty())
                                            <p class="mb-0 text-muted">No expense records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Expenses:
                                                ₹{{ number_format($data['expenses']->sum('amount_spent'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['expenses']->min('expense_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['expenses']->max('expense_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Bricks Sales Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#salesCollapse" aria-expanded="false" aria-controls="salesCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-cart me-2"></i> Bricks Sales
                                        </span>
                                    </button>
                                </h2>
                                <div id="salesCollapse" class="accordion-collapse collapse" data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['bricks_sales']->isEmpty())
                                            <p class="mb-0 text-muted">No sales records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Bricks:
                                                {{ number_format($data['bricks_sales']->sum('quantity'), 0) }}, Total Amount:
                                                ₹{{ number_format($data['bricks_sales']->sum('total_amount'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['bricks_sales']->min('sale_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['bricks_sales']->max('sale_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Labour Payments Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#labourPaymentsCollapse" aria-expanded="false"
                                        aria-controls="labourPaymentsCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-cash-stack me-2"></i> Labour Payments
                                        </span>
                                    </button>
                                </h2>
                                <div id="labourPaymentsCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['labour_payments']->isEmpty())
                                            <p class="mb-0 text-muted">No labour payment records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Paid:
                                                ₹{{ number_format($data['labour_payments']->sum('paid_amount'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['labour_payments']->min('payment_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['labour_payments']->max('payment_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Labour Work Details Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#labourWorkCollapse" aria-expanded="false"
                                        aria-controls="labourWorkCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-hammer me-2"></i> Labour Work Details
                                        </span>
                                    </button>
                                </h2>
                                <div id="labourWorkCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['labour_work_details']->isEmpty())
                                            <p class="mb-0 text-muted">No work details found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Bricks Quantity:
                                                {{ number_format($data['labour_work_details']->sum('bricks_quantity'), 0) }}
                                                (from
                                                {{ \Carbon\Carbon::parse($data['labour_work_details']->min('work_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['labour_work_details']->max('work_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Party Payments Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#partyPaymentsCollapse" aria-expanded="false"
                                        aria-controls="partyPaymentsCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-credit-card me-2"></i> Party Payments
                                        </span>
                                    </button>
                                </h2>
                                <div id="partyPaymentsCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['payments']->isEmpty())
                                            <p class="mb-0 text-muted">No payment records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Amount Paid:
                                                ₹{{ number_format($data['payments']->sum('amount_paid'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['payments']->min('payment_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['payments']->max('payment_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Purchases Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#purchasesCollapse" aria-expanded="false"
                                        aria-controls="purchasesCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-bag me-2"></i> Purchases
                                        </span>
                                    </button>
                                </h2>
                                <div id="purchasesCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['purchases']->isEmpty())
                                            <p class="mb-0 text-muted">No purchase records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Quantity:
                                                {{ number_format($data['purchases']->sum('quantity'), 2) }}, Total Amount:
                                                ₹{{ number_format($data['purchases']->sum('total_amount'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['purchases']->min('date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['purchases']->max('date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Payments Summary -->
                            <div class="accordion-item border-0 shadow-sm mb-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#vehiclePaymentsCollapse" aria-expanded="false"
                                        aria-controls="vehiclePaymentsCollapse">
                                        <span class="d-flex align-items-center">
                                            <i class="bi bi-truck me-2"></i> Vehicle Payments
                                        </span>
                                    </button>
                                </h2>
                                <div id="vehiclePaymentsCollapse" class="accordion-collapse collapse"
                                    data-bs-parent="#reportAccordion">
                                    <div class="accordion-body">
                                        @if ($data['vehicle_payments']->isEmpty())
                                            <p class="mb-0 text-muted">No vehicle payment records found.</p>
                                        @else
                                            <p class="mb-0 fw-medium">Total Paid Amount:
                                                ₹{{ number_format($data['vehicle_payments']->sum('paid_amount'), 2) }} (from
                                                {{ \Carbon\Carbon::parse($data['vehicle_payments']->min('payment_date'))->format('d-m-Y') }}
                                                to
                                                {{ \Carbon\Carbon::parse($data['vehicle_payments']->max('payment_date'))->format('d-m-Y') }})
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .dashboard-main-body {
            padding: 1.5rem;
        }

        .card {
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .card-title {
            font-size: 1.25rem;
            color: #1a1a1a;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        }

        .btn-primary {
            border-radius: 0.5rem;
            padding: 0.75rem;
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .accordion-button {
            border-radius: 0.5rem;
            background-color: #fff;
            color: #1a1a1a;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f1f3f5;
            color: #007bff;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion-body {
            background-color: #fff;
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1rem;
            }

            .btn-primary {
                padding: 0.5rem;
            }
        }
    </style>
@endsection
