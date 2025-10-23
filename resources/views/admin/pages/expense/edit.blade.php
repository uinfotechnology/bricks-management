@extends('admin.include.layout')

@push('title')
    Update Expense
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Expense</h5>
                        <div>
                            <a href="{{ route('admin.expense.expenseList') }}" class="btn btn-sm btn-primary">Expense List</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                              action="{{ route('admin.expense.updateExpense', Crypt::encrypt($expense->id)) }}" novalidate>
                            @csrf

                            <div class="col-md-3">
                                <label class="form-label">Purpose Of Expense <span class="text-danger">*</span></label>
                                <input type="text" name="purpose_of_expense" class="form-control"
                                       value="{{ old('purpose_of_expense', $expense->purpose_of_expense) }}" required>
                                @error('purpose_of_expense')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" class="form-control"
                                       value="{{ old('recipient_name', $expense->recipient_name) }}">
                                @error('recipient_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Amount Spent <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount_spent" class="form-control"
                                       value="{{ old('amount_spent', $expense->amount_spent) }}" required>
                                @error('amount_spent')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select name="payment_mode" class="form-control" required>
                                    <option value="">Select Mode</option>
                                    <option value="cash" {{ old('payment_mode', $expense->payment_mode) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="upi" {{ old('payment_mode', $expense->payment_mode) == 'upi' ? 'selected' : '' }}>UPI</option>
                                    <option value="bank" {{ old('payment_mode', $expense->payment_mode) == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="online" {{ old('payment_mode', $expense->payment_mode) == 'online' ? 'selected' : '' }}>Online</option>
                                </select>
                                @error('payment_mode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="expense_date" class="form-control"
                                       value="{{ old('expense_date', $expense->expense_date) }}" required>
                                @error('expense_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $expense->remarks) }}</textarea>
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
