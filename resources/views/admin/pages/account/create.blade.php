@extends('admin.include.layout')

@push('title')
    Account Creation
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Account</h5>
                        <div>
                            <a href="{{ route('admin.account.list') }}" class="btn btn-sm btn-primary">Account List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST" action="{{ route('admin.account.create') }}"
                            novalidate>
                            @csrf

                            <!-- Account Type -->
                            <div class="col-md-6">
                                <label class="form-label">Account Type <span class="text-danger">*</span> </label>
                                <select name="account_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    @foreach ($accountType as $item)
                                        <option value="{{ $item }}"
                                            {{ old('account_type') == $item ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Party Name -->
                            <div class="col-md-6">
                                <label class="form-label">Party Name <span class="text-danger">*</span></label>
                                <input type="text" name="party_name" class="form-control" placeholder="Enter Party Name"
                                    value="{{ old('party_name') }}" required>
                                @error('party_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-6">
                                <label class="form-label">Contact Person </label>
                                <input type="text" name="contact_person" class="form-control"
                                    placeholder="Enter Contact Person" value="{{ old('contact_person') }}">
                                @error('contact_person')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile_number" class="form-control"
                                    placeholder="Enter Mobile Number" value="{{ old('mobile_number') }}" maxlength="10" required>
                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Secondary Mobile Number</label>
                                <input type="text" name="secondary_mobile_number" class="form-control"
                                    placeholder="Enter Secondary Mobile Number"
                                    value="{{ old('secondary_mobile_number') }}" maxlength="10">
                                @error('secondary_mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- GSTIN -->
                            <div class="col-md-6">
                                <label class="form-label">GSTIN</label>
                                <input type="text" name="gst_number" class="form-control" placeholder="Enter GST Number"
                                    value="{{ old('gst_number') }}" maxlength="15">
                                @error('gst_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- PAN No -->
                            <div class="col-md-6">
                                <label class="form-label">PAN No</label>
                                <input type="text" name="pan_number" class="form-control" placeholder="Enter PAN Number"
                                    value="{{ old('pan_number') }}" maxlength="10">
                                @error('pan_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Opening Balance -->
                            <div class="col-md-6">
                                <label class="form-label">Opening Balance</label>
                                <input type="number" name="opening_balance" class="form-control"
                                    placeholder="Enter Opening Balance" value="{{ old('opening_balance',0) }}" min="0"
                                    step="any" >
                                @error('opening_balance')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address"
                                    value="{{ old('address') }}" required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bank Name -->
                            <div class="col-md-6">
                                <label class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control" placeholder="Enter Bank Name"
                                    value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Account Number -->
                            <div class="col-md-6">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="account_number" class="form-control"
                                    placeholder="Enter Account Number" value="{{ old('account_number') }}">
                                @error('account_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Account Holder Name</label>
                                <input type="text" name="account_holder_name" class="form-control"
                                    placeholder="Enter Account Holder Name" value="{{ old('account_holder_name') }}">
                                @error('account_holder_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- IFSC Code -->
                            <div class="col-md-4">
                                <label class="form-label">IFSC Code</label>
                                <input type="text" name="ifsc_code" class="form-control"
                                    placeholder="Enter IFSC Code" value="{{ old('ifsc_code') }}">
                                @error('ifsc_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date</label>
                                <input type="date" name="created_date" class="form-control" value="{{ old('created_date', date('Y-m-d'))  }}">
                                @error('created_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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

                            <div class="col-12">
                                <button class="btn btn-primary-600" type="submit">Create New</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
