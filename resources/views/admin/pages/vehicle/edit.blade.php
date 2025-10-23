@extends('admin.include.layout')

@push('title')
    Vehicle Update
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Update Vehicle</h5>
                        <div>
                            <a href="{{ route('admin.vehicle.vehicleList') }}" class="btn btn-sm btn-primary">Vehicle List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.vehicle.updateVehicle', Crypt::encrypt($vehicle->id)) }}" novalidate
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-2">
                                <label class="form-label">Vehicle Type <span class="text-danger">*</span> </label>
                                <select name="vehicle_type" class="form-control" id="vehicle_type"   onchange="toggleRentAmount()">
                                    <option value="">Select Vehicle Type</option>
                                    <option value="company"
                                        {{ old('vehicle_type', $vehicle->vehicle_type) == 'company' ? 'selected' : '' }}>
                                        Company</option>
                                    <option value="rent"
                                        {{ old('vehicle_type', $vehicle->vehicle_type) == 'rent' ? 'selected' : '' }}>Rent
                                    </option>
                                    <option value="customer"
                                        {{ old('vehicle_type', $vehicle->vehicle_type) == 'customer' ? 'selected' : '' }}>
                                        Customer</option>
                                </select>
                                @error('vehicle_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Ownar Name <span class="text-danger">*</span></label>
                                <input type="text" name="ownar_name" class="form-control" placeholder="Enter Ownar Name"
                                    value="{{ old('ownar_name', $vehicle->ownar_name) }}" required>
                                @error('ownar_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Contact Number</label>
                                <input type="number" name="contact_no" class="form-control" placeholder="Enter Contact No"
                                    value="{{ old('contact_no', $vehicle->contact_no) }}" required>
                                @error('contact_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Address </label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                    value="{{ old('address', $vehicle->address) }}" required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter City"
                                    value="{{ old('city', $vehicle->city) }}" required>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" placeholder="Enter State"
                                    value="{{ old('state', $vehicle->state) }}" required>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_name" class="form-control"
                                    placeholder="Enter Vehicle Name"
                                    value="{{ old('vehicle_name', $vehicle->vehicle_name) }}" required>
                                @error('vehicle_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Vehicle Number <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_number" class="form-control"
                                    placeholder="Enter Vehicle Number"
                                    value="{{ old('vehicle_number', $vehicle->vehicle_number) }}" required>
                                @error('vehicle_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Aadhar Card </label>
                                <input name="aadhar_card" type="file"
                                    class="form-control @error('aadhar_card') is-invalid @enderror" id="file"
                                    onchange="return fileValidation()" accept="image/*">
                                @error('aadhar_card')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <div id="imgPreview">
                                    <img src="{{ $vehicle->aadhar_card ? asset('upload/vehicle/' . $vehicle->aadhar_card) : asset('assets/images/no-image.png') }}"
                                        class="Photo" alt="" height="60" width="60"
                                        style="margin-top: 32px;" />
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Vehicle Document</label>
                                <input name="vehicle_document" type="file"
                                    class="form-control @error('vehicle_document') is-invalid @enderror" id="file_1"
                                    onchange="return fileValidation_1()" accept="image/*">
                                @error('vehicle_document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <div id="imgPreview_1">
                                    <img src="{{ $vehicle->vehicle_document ? asset('upload/vehicle/' . $vehicle->vehicle_document) : asset('assets/images/no-image.png') }}"
                                        class="Photo" alt="" height="60" width="60"
                                        style="margin-top: 32px;" />
                                </div>
                            </div>

                            <div class="col-md-3" id="rentAmountDiv" style="display: none;">
                                <label class="form-label">Rent Amount</label>
                                <input type="number" name="rent_amount" class="form-control"
                                    placeholder="Enter Rent Amount" value="{{ old('rent_amount', $vehicle->rent_amount) }}">
                                @error('rent_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                    value="{{ old('remarks', $vehicle->remarks) }}">
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
                            '" style="height:60px;width:60px;margin-top: 17px;"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }

        function fileValidation_1() {
            var fileInput = document.getElementById('file_1');
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
                        document.getElementById('imgPreview_1').innerHTML =
                            '<img src="' + e.target.result +
                            '" style="height:60px;width:60px;margin-top: 17px;"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }
    </script>
    <!-- Image upload validation end -->

    <script>
        function toggleRentAmount() {
            var vehicleType = document.getElementById('vehicle_type').value;
            var rentDiv = document.getElementById('rentAmountDiv');

            if (vehicleType === 'rent') {
                rentDiv.style.display = 'block';
            } else {
                rentDiv.style.display = 'none';
            }
        }

        // Page load par check karne ke liye (old value ke liye)
        document.addEventListener('DOMContentLoaded', function() {
            toggleRentAmount();
        });
    </script>
@endsection
