@extends('admin.include.layout')

@push('title')
    Edit Company Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Edit Company Details</h5>
                        <div>
                            <a href="{{ route('admin.company_details.companyDetailsView') }}"
                                class="btn btn-sm btn-primary">Company Details</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.company_details.updateCompanyDetails', Crypt::encrypt($company->id)) }}"
                            novalidate enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-6">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" id="company_name"
                                    placeholder="Enter Company Name"
                                    value="{{ old('company_name', $company->company_name) }}" required>
                                @error('company_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Registration Number <span class="text-danger">*</span></label>
                                <input type="text" name="registration_number" class="form-control"
                                    id="registration_number" placeholder="Enter Registration Number"
                                    value="{{ old('registration_number', $company->registration_number) }}" required>
                                @error('registration_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="Enter Phone Number" value="{{ old('phone', $company->phone) }}"
                                    maxlength="10" required>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" id="address"
                                    placeholder="Enter Address" value="{{ old('address', $company->address) }}" required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" id="city"
                                    placeholder="Enter City" value="{{ old('city', $company->city) }}" required>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">State <span class="text-danger">*</span></label>
                                <input type="text" name="state" class="form-control" id="state"
                                    placeholder="Enter State" value="{{ old('state', $company->state) }}" required>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Pin Code <span class="text-danger">*</span></label>
                                <input type="text" name="pincode" class="form-control" id="pincode"
                                    placeholder="Enter Pin Code" value="{{ old('pincode', $company->pincode) }}" required>
                                @error('pincode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">GST Number <span class="text-danger">*</span></label>
                                <input type="text" name="gst_number" class="form-control" id="gst_number"
                                    placeholder="Enter GST Number" value="{{ old('gst_number', $company->gst_number) }}"
                                    maxlength="15" required>
                                @error('gst_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">PAN Number <span class="text-danger">*</span></label>
                                <input type="text" name="pan_number" class="form-control" id="pan_number"
                                    placeholder="Enter PAN Number" value="{{ old('pan_number', $company->pan_number) }}"
                                    maxlength="10" required>
                                @error('pan_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">TAN Number <span class="text-danger">*</span></label>
                                <input type="text" name="tan_number" class="form-control" id="tan_number"
                                    placeholder="Enter TAN Number" value="{{ old('tan_number', $company->tan_number) }}"
                                    required>
                                @error('tan_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Bank Name <span class="text-danger">*</span></label>
                                <input type="text" name="bank_name" class="form-control" id="bank_name"
                                    placeholder="Enter Bank Name" value="{{ old('bank_name', $company->bank_name) }}"
                                    required>
                                @error('bank_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Account Number <span class="text-danger">*</span></label>
                                <input type="text" name="account_number" class="form-control" id="account_number"
                                    placeholder="Enter Account Number"
                                    value="{{ old('account_number', $company->account_number) }}" required>
                                @error('account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">IFSC Code <span class="text-danger">*</span></label>
                                <input type="text" name="ifsc_code" class="form-control" id="ifsc_code"
                                    placeholder="Enter IFSC Code" value="{{ old('ifsc_code', $company->ifsc_code) }}"
                                    required>
                                @error('ifsc_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                                <input type="text" name="account_holder_name" class="form-control"
                                    id="account_holder_name" placeholder="Enter Account Holder Name"
                                    value="{{ old('account_holder_name', $company->account_holder_name) }}" required>
                                @error('account_holder_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Logo <span class="text-danger">*</span></label>
                                <input name="upload_image" type="file"
                                    class="form-control @error('upload_image') is-invalid @enderror" id="file"
                                    onchange="return fileValidation()" accept="image/*"
                                    value="{{ old('upload_image') }}">
                                @error('upload_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-1">
                                <img src="{{ asset('upload/company') }}/{{ $company->image }}" alt="" style="80px;width:80px;">
                            </div>

                            <div class="col-md-1">
                                <div id="imageview"><img src="{{ asset('assets/images/no-image.png') }}" class="logo" alt="" style="60px;width:60px;margin-top:22px;" />
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Update</button>
                                <a href="{{ route('admin.company_details.companyDetailsView') }}"
                                    class="btn btn-secondary">Cancel</a>
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
            var fileInput =
                document.getElementById('file');

            var filePath = fileInput.value;

            // Allowing file type
            var allowedExtensions =
                /(\.jpg|\.jpeg|\.png|\.webp)$/i;

            if (!allowedExtensions.exec(filePath)) {
                alert('Invalid file type');
                fileInput.value = '';
                return false;
            } else {

                // Image preview
                if (fileInput.files && fileInput.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(
                                'imageview').innerHTML =
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
