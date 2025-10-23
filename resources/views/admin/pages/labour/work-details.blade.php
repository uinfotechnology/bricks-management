@extends('admin.include.layout')

@push('title')
    Labour Work Details
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">

                {{-- Labour Basic Info in Card Layout --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h6>Labour Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Name</p>
                                        <h6 class="mb-0">{{ $labour->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Labour Type</p>
                                        <h6 class="mb-0">{{ $labour->labour_type_name }}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Mobile</p>
                                        <h6 class="mb-0">{{ $labour->mobile_number }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="card p-3 border h-100">
                                        <p class="mb-1 text-muted small">Total Bricks</p>
                                        <h6 class="mb-0">
                                            {{ $labourWorkDetails->sum('bricks_quantity') }}
                                        </h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Labour Work Details --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h6>Work Details</h6>
                    </div>
                    <div class="card-body">
                        @if ($labourWorkDetails->isEmpty())
                            <p class="text-danger">No work records found.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bricks Quantity</th>
                                        <th>Work Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($labourWorkDetails as $index => $work)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $work->bricks_quantity }}</td>
                                            <td>{{ date('d-m-Y', strtotime($work->work_date)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
