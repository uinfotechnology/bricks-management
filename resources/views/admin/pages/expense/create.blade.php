@extends('admin.include.layout')

@push('title')
    Product Creation
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Expense</h5>
                        <div>
                            <a href="{{ route('admin.expense.expenseList') }}" class="btn btn-sm btn-primary">Expense List</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.expense.storeExpense') }}" novalidate>
                            @csrf

                            <div class="col-md-3">
                                <label class="form-label">Purpose Of Expense <span class="text-danger">*</span></label>
                                <input type="text" name="purpose_of_expense" class="form-control"
                                    placeholder="Enter Purpose Of Expense" value="{{ old('purpose_of_expense') }}" required>
                                @error('purpose_of_expense')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" class="form-control"
                                    placeholder="Enter Recipient Name" value="{{ old('recipient_name') }}" required>
                                @error('recipient_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Amount Spent <span class="text-danger">*</span></label>
                                <input type="text" name="amount_spent" class="form-control" placeholder="Enter Amount"
                                    value="{{ old('amount_spent') }}" required>
                                @error('amount_spent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select name="payment_mode" class="form-control" required>
                                    <option value="">Select Mode</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }} selected>
                                        Cash
                                    </option>
                                    <option value="upi" {{ old('payment_mode') == 'upi' ? 'selected' : '' }}>Upi
                                    </option>
                                    <option value="bank" {{ old('payment_mode') == 'bank' ? 'selected' : '' }}>Bank
                                        Transfer</option>
                                    <option value="online" {{ old('payment_mode') == 'online' ? 'selected' : '' }}>Online
                                    </option>
                                </select>
                                @error('payment_mode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="expense_date" class="form-control"
                                    value="{{ old('expense_date', date('Y-m-d')) }}" required>
                                @error('expense_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2" placeholder="Enter any remarks">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
