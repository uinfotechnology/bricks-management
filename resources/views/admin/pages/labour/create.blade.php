@extends('admin.include.layout')

@push('title')
    Labour Creation
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Labour</h5>
                        <div>
                            <a href="{{ route('admin.labour.labourList') }}" class="btn btn-sm btn-primary">Labour List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.labour.createLabour') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Labur Type -->
                            <div class="col-md-4">
                                <label class="form-label">Labour Type <span class="text-danger">*</span></label>
                                <select name="labour_type_id" class="form-control" required>
                                    <option value="">Select Type</option>
                                    @foreach ($getData as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('labour_type_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->labour_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('labour_type_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Rate Per Thousand Bricks <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="rate_per_thousand" class="form-control" placeholder="Enter Rate"
                                    value="{{ old('rate_per_thousand') }}" step="0.01">
                                @error('rate_per_thousand')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="col-md-4">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-md-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile_number" class="form-control"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}" maxlength="15"
                                    required>
                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Secondary Mobile -->
                            <div class="col-md-3">
                                <label class="form-label">Secondary Mobile Number</label>
                                <input type="text" name="secondary_mobile_number" class="form-control"
                                    placeholder="Enter Mobile Number" value="{{ old('secondary_mobile_number') }}"
                                    maxlength="15">
                                @error('secondary_mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- DOB -->
                            <div class="col-md-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}"
                                    required>
                                @error('dob')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Aadhar No -->
                            <div class="col-md-3">
                                <label class="form-label">Aadhar No</label>
                                <input type="text" name="aadhar_no" class="form-control" placeholder="Enter Aadhar No"
                                    value="{{ old('aadhar_no') }}" maxlength="12" required>
                                @error('aadhar_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PAN No -->
                            <div class="col-md-3">
                                <label class="form-label">PAN No</label>
                                <input type="text" name="pan_number" class="form-control" placeholder="Enter PAN Number"
                                    value="{{ old('pan_number') }}" maxlength="10">
                                @error('pan_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                    value="{{ old('address') }}" required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Enter City"
                                    value="{{ old('city') }}" required>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" placeholder="Enter State"
                                    value="{{ old('state') }}" required>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Upload Image -->
                            <div class="col-md-5">
                                <label class="form-label">Photo</label>
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
                            <div class="col-md-12">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                    value="{{ old('remarks') }}">
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Create New</button>
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
    </script>
    <!-- Image upload validation end -->
@endsection
