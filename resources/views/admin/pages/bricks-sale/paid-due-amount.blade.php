@extends('admin.include.layout')

@push('title')
    Update Due Amount
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Due Amount</h5>
                        <div>
                            <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks
                                Sale List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_sale.updateDueAmount', Crypt::encrypt($getData->id)) }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Quantity -->
                            <div class="col-md-4">
                                <label class="form-label">Quantity (In Pieces) </label>
                                <input type="number" name="quantity" class="form-control"
                                    value="{{ old('quantity', $getData->quantity) }}" readonly>
                                @error('quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rate -->
                            <div class="col-md-4">
                                <label class="form-label">Rate Per Thousand </label>
                                <input type="number" name="rate_per_thousand" class="form-control"
                                    value="{{ old('rate_per_thousand', $getData->rate_per_thousand) }}" step="0.01"
                                    readonly>
                                @error('rate_per_thousand')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Total Amount -->
                            <div class="col-md-4">
                                <label class="form-label">Total Amount</label>
                                <input type="number" name="total_amount" class="form-control"
                                    value="{{ old('total_amount', $getData->total_amount) }}" readonly>
                            </div>

                            <!-- Already Paid Amount -->
                            <div class="col-md-4">
                                <label class="form-label">Already Paid Amount</label>
                                <input type="number" class="form-control"
                                    value="{{ old('amount_received', $getData->amount_received) }}" readonly>
                            </div>

                            <!-- Pay Due Now -->
                            <div class="col-md-4">
                                <label class="form-label">Pay Due Amount <span class="text-danger">*</span></label>
                                <input type="number" name="amount_received" class="form-control" value="0" step="0.01"
                                    required>
                                @error('amount_received')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remaining Due -->
                            <div class="col-md-4">
                                <label class="form-label">Remaining Due</label>
                                <input type="number" name="due_amount" class="form-control"
                                    value="{{ old('due_amount', $getData->due_amount) }}" readonly>
                            </div>

                            <!-- Date -->
                            <div class="col-md-4">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="sale_date" class="form-control"
                                    value="{{ old('date', $getData->sale_date) }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Update Due Payment</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quantityInput = document.querySelector('input[name="quantity"]');
        const rateInput = document.querySelector('input[name="rate_per_thousand"]');
        const totalInput = document.querySelector('input[name="total_amount"]');
        const paidNowInput = document.querySelector('input[name="amount_received"]');
        const alreadyPaid = parseFloat({{ $getData->amount_received }}) || 0;
        const dueInput = document.querySelector('input[name="due_amount"]');

        function calculateTotal() {
            let quantity = parseFloat(quantityInput.value) || 0;
            let rate = parseFloat(rateInput.value) || 0;
            let total = (quantity / 1000) * rate;
            totalInput.value = total.toFixed(2);
            calculateRemainingDue();
        }

        function calculateRemainingDue() {
            let total = parseFloat(totalInput.value) || 0;
            let payNow = parseFloat(paidNowInput.value) || 0;
            let remaining = total - (alreadyPaid + payNow);
            dueInput.value = remaining.toFixed(2);
        }

        quantityInput.addEventListener('input', calculateTotal);
        rateInput.addEventListener('input', calculateTotal);
        paidNowInput.addEventListener('input', calculateRemainingDue);

        // Initialize on page load
        calculateTotal();
    </script>
@endsection
