@extends('admin.include.layout')

@push('title')
    Create Bricks Sale
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Bricks Sale</h5>
                        <div>
                            <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks
                                Sale List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_sale.storeBricksSale') }}" enctype="multipart/form-data"
                            novalidate>
                            @csrf

                            <!-- Vehicle Selection -->
                            <div class="col-md-4">
                                <label class="form-label">Select Vehicle <span class="text-danger">*</span></label>
                                <select name="vehicle_id" class="form-control" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ ucfirst($vehicle->vehicle_type) }} - {{ $vehicle->vehicle_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bricks Type Category -->
                            <div class="col-md-4">
                                <label class="form-label">Bricks Type Category <span class="text-danger">*</span></label>
                                <select name="bricks_type_category_id" id="bricks_type_category" class="form-control"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach ($category as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('bricks_type_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->bricks_type_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bricks_type_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bricks Sub Category -->
                            <div class="col-md-4">
                                <label class="form-label">Bricks Sub Category</label>
                                <select name="bricks_type_sub_category_id" id="bricks_type_sub_category"
                                    class="form-control">
                                    <option value="">Select Sub Category</option>
                                    <!-- Sub categories will be populated via JS -->
                                </select>
                                @error('bricks_type_sub_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Name -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control"
                                    placeholder="Enter Customer Name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Mobile -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Mobile</label>
                                <input type="text" name="customer_mobile" class="form-control"
                                    placeholder="Enter Mobile Number" value="{{ old('customer_mobile') }}" maxlength="15"
                                    required>
                                @error('customer_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Address -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Address <span class="text-danger">*</span></label>
                                <input type="text" name="customer_address" class="form-control"
                                    placeholder="Enter Address" value="{{ old('customer_address') }}" required>
                                @error('customer_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer City -->
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input type="text" name="customer_city" class="form-control" placeholder="Enter City"
                                    value="{{ old('customer_city') }}">
                                @error('customer_city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer State -->
                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <input type="text" name="customer_state" class="form-control" placeholder="Enter State"
                                    value="{{ old('customer_state') }}">
                                @error('customer_state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-3">
                                <label class="form-label">Quantity (In Pieces) <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control" placeholder="Enter Quantity"
                                    value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rate -->
                            <div class="col-md-3">
                                <label class="form-label">Rate Per Thousand <span class="text-danger">*</span></label>
                                <input type="number" name="rate_per_thousand" class="form-control" placeholder="Enter Rate"
                                    value="{{ old('rate_per_thousand') }}" step="0.01" required>
                                @error('rate_per_thousand')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Total Amount -->
                            <div class="col-md-2">
                                <label class="form-label">Total Amount</label>
                                <input type="number" name="total_amount" class="form-control"
                                    placeholder="Total Amount" value="{{ old('total_amount') }}" readonly>
                            </div>

                            <!-- Amount Received -->
                            <div class="col-md-3">
                                <label class="form-label">Amount Received</label>
                                <input type="number" name="amount_received" class="form-control"
                                    placeholder="Amount Received" value="{{ old('amount_received') }}" step="0.01"
                                    required>
                                @error('amount_received')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Due Amount -->
                            <div class="col-md-2">
                                <label class="form-label">Due Amount</label>
                                <input type="number" name="due_amount" class="form-control" placeholder="Due Amount"
                                    value="{{ old('due_amount') }}" step="0.01" required>
                                @error('due_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Payment Mode -->
                            <div class="col-md-3">
                                <label class="form-label">Payment Mode</label>
                                <select name="payment_mode" class="form-control">
                                    <option value="">Select Payment Mode</option>
                                    <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="upi" {{ old('payment_mode') == 'upi' ? 'selected' : '' }}>UPI
                                    </option>
                                    <option value="bank_transfer"
                                        {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                    </option>
                                </select>
                                @error('payment_mode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="col-md-2">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="sale_date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Upload Image -->
                            <div class="col-md-3">
                                <label class="form-label">Upload Slip (Optional)</label>
                                <input name="upload_image" type="file"
                                    class="form-control @error('upload_image') is-invalid @enderror" id="file"
                                    onchange="return fileValidation()" accept="image/*">
                                @error('upload_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <div id="imgPreview">
                                    <img src="{{ asset('assets/images/no-image.png') }}" class="Photo" alt=""
                                        height="60" width="60" style="margin-top: 22px;" />
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-8">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                    value="{{ old('remarks') }}">
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Create Sale</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image upload validation start -->
    <script>
        function fileValidation() {
            var fileInput = document.getElementById('file');
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;

            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } else {
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('imgPreview').innerHTML =
                            '<img src="' + e.target.result +
                            '" style="height:60px;width:60px;margin-bottom:10px;"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }

        // Total amount calculation
        document.querySelector('input[name="quantity"]').addEventListener('input', calculateTotal);
        document.querySelector('input[name="rate_per_thousand"]').addEventListener('input', calculateTotal);
        document.querySelector('input[name="amount_received"]').addEventListener('input', calculateDue);

        function calculateTotal() {
            let quantity = parseFloat(document.querySelector('input[name="quantity"]').value) || 0;
            let rate = parseFloat(document.querySelector('input[name="rate_per_thousand"]').value) || 0;
            let total = (quantity / 1000) * rate;
            document.querySelector('input[name="total_amount"]').value = total.toFixed(2);

            calculateDue();
        }

        // New function to calculate due amount
        function calculateDue() {
            let total = parseFloat(document.querySelector('input[name="total_amount"]').value) || 0;
            let paid = parseFloat(document.querySelector('input[name="amount_received"]').value) || 0;
            let due = total - paid;
            document.querySelector('input[name="due_amount"]').value = due.toFixed(2);
        }


        const subCategories = @json($subCategory);

        const categorySelect = document.getElementById('bricks_type_category');
        const subCategorySelect = document.getElementById('bricks_type_sub_category');

        categorySelect.addEventListener('change', function() {
            const selectedCategoryId = this.value;

            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

            const filteredSubCategories = subCategories.filter(
                item => item.bricks_type_category_id == selectedCategoryId
            );

            filteredSubCategories.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.bricks_type_sub_category_name;
                subCategorySelect.appendChild(option);
            });
        });
    </script>
@endsection
