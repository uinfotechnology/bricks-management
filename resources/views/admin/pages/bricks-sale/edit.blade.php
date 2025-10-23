@extends('admin.include.layout')

@push('title')
    Update Bricks Sale
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Bricks Sale</h5>
                        <div>
                            <a href="{{ route('admin.bricks_sale.bricksSaleList') }}" class="btn btn-sm btn-primary">Bricks
                                Sale List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.bricks_sale.updateBricksSale', Crypt::encrypt($getData->id)) }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Vehicle Selection -->
                            <div class="col-md-4">
                                <label class="form-label">Select Vehicle <span class="text-danger">*</span></label>
                                <select name="vehicle_id" class="form-control" required>
                                    <option value="">Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}"
                                            {{ old('vehicle_id', $getData->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
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
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('bricks_type_category_id', $getData->bricks_type_category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->bricks_type_category_name }}
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
                                    @foreach ($subCategory->where('bricks_type_category_id', $getData->bricks_type_category_id) as $sub)
                                        <option value="{{ $sub->id }}"
                                            {{ old('bricks_type_sub_category_id', $getData->bricks_type_sub_category_id) == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->bricks_type_sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bricks_type_sub_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Name -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control"
                                    value="{{ old('customer_name', $getData->customer_name) }}" required>
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Mobile -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Mobile</label>
                                <input type="text" name="customer_mobile" class="form-control"
                                    value="{{ old('customer_mobile', $getData->customer_mobile) }}" maxlength="15"
                                    required>
                                @error('customer_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer Address -->
                            <div class="col-md-4">
                                <label class="form-label">Customer Address <span class="text-danger">*</span></label>
                                <input type="text" name="customer_address" class="form-control"
                                    value="{{ old('customer_address', $getData->customer_address) }}" required>
                                @error('customer_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer City -->
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="customer_city" class="form-control"
                                    value="{{ old('customer_city', $getData->customer_city) }}">
                                @error('customer_city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Customer State -->
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" name="customer_state" class="form-control"
                                    value="{{ old('customer_state', $getData->customer_state) }}">
                                @error('customer_state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                    @if ($getData->upload_image && $getData->upload_image != 'no-image.png')
                                        <img src="{{ asset('upload/bricks-sale/' . $getData->upload_image) }}"
                                            alt="Slip" style="height:60px;width:60px;margin-top:20px;">
                                    @else
                                        <img src="{{ asset('upload/bricks-sale/no-image.png') }}" alt="No Image"
                                            style="height:60px;width:60px;margin-top:20px;">
                                    @endif
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-8">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control"
                                    value="{{ old('remarks', $getData->remarks) }}">
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
                            '" style="height:60px;width:60px;margin-top:20px;"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }

        // Sub Categories
        const subCategories = @json($subCategory);

        const categorySelect = document.getElementById('bricks_type_category');
        const subCategorySelect = document.getElementById('bricks_type_sub_category');
        const selectedSubCat = "{{ $getData->bricks_type_sub_category_id }}";

        function populateSubcategories(catId) {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            const filteredSubCategories = subCategories.filter(item => item.bricks_type_category_id == catId);
            filteredSubCategories.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.bricks_type_sub_category_name;
                if (item.id == selectedSubCat) option.selected = true;
                subCategorySelect.appendChild(option);
            });
        }

        populateSubcategories(categorySelect.value);

        categorySelect.addEventListener('change', function() {
            populateSubcategories(this.value);
        });
    </script>
@endsection
