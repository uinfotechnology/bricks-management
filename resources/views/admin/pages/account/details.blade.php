@extends('admin.include.layout')

@push('title')
    Account Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                {{-- Table Result --}}
                @isset($accountDetails)
                    <div class="card mt-4">
                        <div class="col-xxl-12">
                            <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                                <div class="card-body p-24 pt-10">

                                    {{-- Account Details Only --}}
                                    <div class="card mt-4">
                                        <div class="card-header d-flex justify-content-between">
                                            <h6 class="mb-0">Account Details</h6>
                                            <div>
                                                <a href="{{ route('admin.account.list') }}"
                                                    class="btn btn-sm btn-primary">Back </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @if (!$accountDetails)
                                                <p class="text-danger">No records found for the selected filters.</p>
                                            @else
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Account Type</th>
                                                        <td>{{ $accountDetails->product_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Party Name</th>
                                                        <td>{{ $accountDetails->party_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Contact Person</th>
                                                        <td>{{ $accountDetails->contact_person }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Mobile No</th>
                                                        <td>{{ $accountDetails->mobile_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Secondary Mobile</th>
                                                        <td>{{ $accountDetails->secondary_mobile_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>GST No</th>
                                                        <td>{{ $accountDetails->gst_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>PAN No</th>
                                                        <td>{{ $accountDetails->pan_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Opening Balance</th>
                                                        <td>{{ number_format($accountDetails->opening_balance, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ $accountDetails->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <td>{{ $accountDetails->bank_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Account Number</th>
                                                        <td>{{ $accountDetails->account_number }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>IFSC Code</th>
                                                        <td>{{ $accountDetails->ifsc_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Account Holder</th>
                                                        <td>{{ $accountDetails->account_holder_name }}</td>
                                                    </tr>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- End Account Details --}}

                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection
