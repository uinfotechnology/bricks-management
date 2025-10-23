@extends('admin.include.layout')

@push('title')
    Payment Creation
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Payment for Purchase #{{ $purchase->bill_no ?? 'N/A' }} (Bill No)</h5>
                    </div>
                    <div class="card-body">
                        <!-- Payment Form -->
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.payment.storePayment') }}" novalidate>
                            @csrf

                            <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                            <input type="hidden" name="party_id" value="{{ $purchase->party_id }}">

                            <!-- Display Purchase Details in Readonly Inputs -->
                            <div class="col-md-3">
                                <label class="form-label">Party Name</label>
                                <input type="text" class="form-control" value="{{ $purchase->party_name ?? 'N/A' }}"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Total Amount</label>
                                <input type="text" name="total_amount" id="totalAmount" class="form-control"
                                    value="{{ number_format($purchase->total_amount, 2, '.', '') }}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Due Amount</label>
                                <input type="text" id="dueAmount" class="form-control"
                                    value="{{ number_format($due_amount, 2, '.', '') }}" readonly>
                            </div>

                            <!-- Paid Amount -->
                            <div class="col-md-3">
                                <label class="form-label">Paid Amount (Till Now)</label>
                                <input type="text" class="form-control" min="0"
                                    value="{{ number_format($total_paid, 2, '.', '') }}" readonly>
                            </div>

                            <!-- Pay Amount -->
                            <div class="col-md-3">
                                <label class="form-label">Pay Amount</label>
                                <input type="number" step="0.01" id="payAmount" name="amount_paid" class="form-control"
                                    placeholder="Enter Pay Amount">
                                @error('amount_paid')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Payment Mode -->
                            <div class="col-md-3">
                                <label class="form-label">Payment Mode <span class="text-danger">*</span></label>
                                <select name="payment_mode" class="form-control" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
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

                            <div class="col-md-3">
                                <label class="form-label">Purchase Date</label>
                                <input type="text" class="form-control"
                                    value="{{ $purchase->date ? date('d-m-Y', strtotime($purchase->date)) : 'N/A' }}"
                                    readonly>
                            </div>

                            <!-- Payment Date -->
                            <div class="col-md-3">
                                <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control"
                                    value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                @error('payment_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="2" placeholder="Enter any remarks">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Save Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Realtime Due Amount Update -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const payAmountInput = document.getElementById("payAmount");
            const dueAmountInput = document.getElementById("dueAmount");

            // current due from DB (readonly input value)
            const initialDue = parseFloat(dueAmountInput.value) || 0;

            payAmountInput.addEventListener("input", function() {
                let payAmount = parseFloat(this.value) || 0;
                let newDue = initialDue - payAmount;
                if (newDue < 0) newDue = 0; // avoid negative due
                dueAmountInput.value = newDue.toFixed(2);
            });
        });
    </script>
@endsection
