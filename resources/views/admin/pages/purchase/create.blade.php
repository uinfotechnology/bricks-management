@extends('admin.include.layout')

@push('title')
    New Purchase
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">New Purchase</h5>
                        <div>
                            <a href="{{ route('admin.purchase.list') }}" class="btn btn-sm btn-primary">Purchase List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.purchase.storePurchase') }}" novalidate>
                            @csrf

                            <!-- Bill No -->
                            <div class="col-md-3">
                                <label class="form-label">Bill No <span class="text-danger">*</span></label>
                                <input type="taxt" name="bill_no" class="form-control" placeholder="Enter Bill No"
                                    value="{{ old('bill_no') }}">
                                @error('bill_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Product Type -->
                            <div class="col-md-2">
                                <label class="form-label">Product Type <span class="text-danger">*</span> </label>
                                <select name="product_id" class="form-control" required>
                                    <option value="">Select Type</option>
                                    @foreach ($product as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('product_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Party -->
                            <div class="col-md-3">
                                <label class="form-label">Party <span class="text-danger">*</span></label>
                                <select name="party_id" class="form-control">
                                    <option value="">Select Party</option>
                                    @foreach ($party as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('party_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->party_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('party_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rate -->
                            <div class="col-md-2">
                                <label class="form-label">Rate <span class="text-danger">*</span></label>
                                <input type="number" name="rate" id="rate" class="form-control"
                                    placeholder="Enter Rate" min="0" value="{{ old('rate') }}" maxlength="15" required>
                                @error('rate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-2">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    placeholder="Enter Quantity" min="0" value="{{ old('quantity') }}" maxlength="15" required>
                                @error('quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Unit -->
                            <div class="col-md-3">
                                <label class="form-label">Unit <span class="text-danger">*</span></label>
                                <select name="unit" class="form-control">
                                    <option value="">Select Unit</option>
                                    <option value="kilogram" {{ old('unit') == 'kilogram' ? 'selected' : '' }}>Kilogram
                                    </option>
                                    <option value="quintal" {{ old('unit') == 'quintal' ? 'selected' : '' }}>Quintal
                                    </option>
                                    <option value="ton" {{ old('unit') == 'ton' ? 'selected' : '' }}>Ton</option>
                                </select>
                                @error('unit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Discount -->
                            <div class="col-md-2">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <input type="number" name="discount" id="discount" class="form-control"
                                    placeholder="Enter Discount" min="0" value="{{ old('discount') }}" maxlength="15" required>
                                @error('discount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- GST -->
                            <div class="col-md-2">
                                <label class="form-label">GST <span class="text-danger">*</span></label>
                                <select name="gst" id="gst" class="form-control">
                                    <option value="">Select GST</option>
                                    <option value="0" {{ old('gst') == '0' ? 'selected' : '' }}>0%</option>
                                    <option value="5" {{ old('gst') == '5' ? 'selected' : '' }}>5%</option>
                                    <option value="12" {{ old('gst') == '12' ? 'selected' : '' }}>12%</option>
                                    <option value="18" {{ old('gst') == '18' ? 'selected' : '' }}>18%</option>
                                    <option value="40" {{ old('gst') == '40' ? 'selected' : '' }}>40%</option>
                                </select>
                                @error('gst')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Total Amount -->
                            <div class="col-md-3">
                                <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control"
                                    placeholder="Enter Total Amount" value="{{ old('total_amount') }}" maxlength="15"
                                    readonly>
                                @error('total_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="col-md-2">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}">
                                @error('date')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rateInput = document.getElementById('rate');
            const quantityInput = document.getElementById('quantity');
            const discountInput = document.getElementById('discount');
            const gstInput = document.getElementById('gst');
            const totalAmountInput = document.getElementById('total_amount');

            function calculateTotalAmount() {
                const rate = parseFloat(rateInput.value) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const gst = parseFloat(gstInput.value) || 0;

                const baseAmount = rate * quantity;
                const afterDiscount = baseAmount - discount;

                const gstAmount = (afterDiscount * gst) / 100;

                const totalAmount = afterDiscount + gstAmount;

                totalAmountInput.value = totalAmount.toFixed(2);
            }

            [rateInput, quantityInput, discountInput, gstInput].forEach(input => {
                input.addEventListener('input', calculateTotalAmount);
                input.addEventListener('change', calculateTotalAmount);
            });
        });
    </script>
@endsection
