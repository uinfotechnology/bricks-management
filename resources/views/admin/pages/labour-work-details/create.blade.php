@extends('admin.include.layout')

@push('title')
    Labour Work Report
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Labour Work Report</h5>
                        <div>
                            <a href="{{ route('admin.labourWorkDetails.labourWorkDetailsList') }}"
                                class="btn btn-sm btn-primary">Labour Work Report List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.labourWorkDetails.createlabourWorkDetails') }}" novalidate>
                            @csrf

                            <!-- Labour Name -->
                            <div class="col-md-3">
                                <label class="form-label">Labour Name <span class="text-danger">*</span> </label>
                                <select name="labour_id" id="labourSelect" class="form-control">
                                    <option value="">Select Labour Name</option>
                                    @foreach ($labour as $value)
                                        <option value="{{ $value->id }}" data-type="{{ $value->labour_type }}"
                                            data-mobile="{{ $value->mobile_number }}" data-dob="{{ $value->dob }}"
                                            data-gender="{{ $value->gender }}" data-aadhar="{{ $value->aadhar_no }}" data-rate_per_thousand="{{ $value->rate_per_thousand }}"
                                            data-address="{{ $value->address }}" data-state="{{ $value->state }}">
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('labour_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Labour Type -->
                            <div class="col-md-3">
                                <label class="form-label">Labour Type</label>
                                <input type="text" id="labourType" class="form-control" readonly>
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-md-2">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" id="mobileNumber" class="form-control" readonly>
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-2">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" id="dob" class="form-control" readonly>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-2">
                                <label class="form-label">Gender</label>
                                <input type="text" id="gender" class="form-control" readonly>
                            </div>

                            <!-- Rate Per Thousand -->
                            <div class="col-md-3">
                                <label class="form-label">Rate Per Thousand</label>
                                <input type="text" id="rate_per_thousand" class="form-control" readonly>
                            </div>

                            <!-- Aadhar No -->
                            <div class="col-md-3">
                                <label class="form-label">Aadhar No</label>
                                <input type="text" id="aadharNo" class="form-control" readonly>
                            </div>

                            <!-- Address -->
                            <div class="col-md-3">
                                <label class="form-label">Address</label>
                                <input type="text" id="address" class="form-control" readonly>
                            </div>

                            <!-- State -->
                            <div class="col-md-3">
                                <label class="form-label">State</label>
                                <input type="text" id="state" class="form-control" readonly>
                            </div>

                            <h5 class="card-title mb-0">Fill Labour Work Data</h5>

                            <!-- Bricks Quantity -->
                            <div class="col-md-3">
                                <label class="form-label">Bricks Quantity <span class="text-danger">*</span></label>
                                <input type="text" name="bricks_quantity" class="form-control"
                                    placeholder="Enter Bricks Quantity">
                                @error('bricks_quantity')
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

                            <!-- Remarks -->
                            <div class="col-md-7">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                    value="{{ old('remarks') }}">
                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Create New</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let labourSelect = document.getElementById("labourSelect");

            labourSelect.addEventListener("change", function() {
                let selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value === "") {
                    document.getElementById("labourType").value = "";
                    document.getElementById("mobileNumber").value = "";
                    document.getElementById("dob").value = "";
                    document.getElementById("gender").value = "";
                    document.getElementById("aadharNo").value = "";
                    document.getElementById("address").value = "";
                    document.getElementById("state").value = "";
                    document.getElementById("rate_per_thousand").value = "";
                    return;
                }

                let rawType = selectedOption.getAttribute("data-type");
                let formattedType = rawType
                    .split("_")
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(" ");

                let rawDob = selectedOption.getAttribute("data-dob");
                let formattedDob = "";
                if (rawDob) {
                    let parts = rawDob.split("-");
                    formattedDob = parts[2] + "-" + parts[1] + "-" + parts[0];
                }

                document.getElementById("labourType").value = formattedType;
                document.getElementById("mobileNumber").value = selectedOption.getAttribute("data-mobile");
                document.getElementById("dob").value = formattedDob;
                document.getElementById("gender").value = selectedOption.getAttribute("data-gender");
                document.getElementById("aadharNo").value = selectedOption.getAttribute("data-aadhar");
                document.getElementById("address").value = selectedOption.getAttribute("data-address");
                document.getElementById("state").value = selectedOption.getAttribute("data-state");
                document.getElementById("rate_per_thousand").value = selectedOption.getAttribute(
                    "data-rate_per_thousand");
            });
        });
    </script>
@endsection
