@extends('admin.include.layout')

@push('title')
    Expense Filter
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Expense Filter</h5>
                        <div>
                            <a href="{{ route('admin.expense.expenseList') }}" class="btn btn-sm btn-primary">
                                Expense List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.expense.getExpenseFilter') }}" class="row gy-3">
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

                @isset($expenses)
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filtered Expense Records</h5>
                        </div>
                        <div class="card-body">
                            @if ($expenses->isEmpty())
                                <p class="text-danger">No records found for the selected date range.</p>
                            @else
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Purpose of Expense</th>
                                            <th>Recipient Name</th>
                                            <th>Amount Spent</th>
                                            <th>Payment Mode</th>
                                            <th>Expense Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->purpose_of_expense }}</td>
                                                <td>{{ $item->recipient_name ?? '-' }}</td>
                                                <td>{{ number_format($item->amount_spent, 2) }}</td>
                                                <td>{{ ucfirst($item->payment_mode) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->expense_date)->format('d-m-Y') }}</td>
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
