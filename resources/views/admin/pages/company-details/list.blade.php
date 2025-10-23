@extends('admin.include.layout')

@push('title')
    Company Details
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/lib/datatable/css/responsive.dataTables.min.css') }}">
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Company Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table striped-table mb-0 company-details-table">
                                <thead>
                                    <tr>
                                        <th scope="col">SI</th>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Registration Number</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">City</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Pin Code </th>
                                        <th scope="col">GST Number</th>
                                        <th scope="col">Pan Number</th>
                                        <th scope="col">Tan Number</th>
                                        <th scope="col">Bank Name</th>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">IFSC Code</th>
                                        <th scope="col">Account Holder Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <!-- Datatables Core -->
    <script src="{{ asset('assets/js/lib/datatable/js/jquery.dataTables.min.js') }}"></script>

    <!-- Buttons -->
    <script src="{{ asset('assets/js/lib/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/buttons.print.min.js') }}"></script>
    <!-- Responsive -->
    <script src="{{ asset('assets/js/lib/datatable/js/dataTables.responsive.min.js') }}"></script>

    <!-- Excel & PDF dependencies -->
    <script src="{{ asset('assets/js/lib/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/datatable/js/vfs_fonts.js') }}"></script>

    <script>
        var companyDetails = "{{ route('admin.company_details.list') }}";
    </script>
    <script src="{{asset('assets/js/datatable.init.js')}}"></script>
@endpush