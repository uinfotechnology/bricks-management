@extends('admin.include.layout')

@push('title')
    Bricks Sale List
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
                        <h5 class="card-title mb-0">Bricks Sale List</h5>
                        <div>
                            <a href="{{ route('admin.bricks_sale.createBricksSaleView') }}"
                                class="btn btn-sm btn-primary">Create
                                New </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table striped-table mb-0 bricks-sale-table">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Bill No</th>
                                        <th>Customer Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Quantity</th>
                                        <th>Address</th>
                                        <th>Contact No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
        var bricksSaleList = "{{ route('admin.bricks_sale.bricksSaleList') }}";
    </script>
    <script src="{{ asset('assets/js/datatable.init.js') }}"></script>
@endpush
