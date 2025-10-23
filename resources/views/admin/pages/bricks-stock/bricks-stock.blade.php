@extends('admin.include.layout')

@push('title')
    Bricks Stock
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
                        <h5 class="card-title mb-0">Bricks Stock</h5>
                        <div>
                            <a href="{{ route('admin.bricks_stock.createBricksStockView') }}"
                                class="btn btn-sm btn-primary">Create New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table striped-table mb-0 bricks-stock-table">
                                <thead>
                                    <tr>
                                        <th scope="col">SI</th>
                                        <th scope="col">Bricks Type</th>
                                        <th scope="col">Bricks Type Sub Category</th>
                                        <th scope="col">Bricks Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align:right">Total Bricks:</th>
                                        <th id="totalBricksFooter"></th>
                                    </tr>
                                </tfoot>
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
        var BricksStockList = "{{ route('admin.bricks_stock.BricksStock') }}";
    </script>
    <script src="{{ asset('assets/js/datatable.init.js') }}"></script>
@endpush
