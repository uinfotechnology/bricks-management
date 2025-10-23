@extends('admin.include.layout')

@push('title')
    Account Balance
@endpush

@section('layout')
<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">
            @isset($accountBalance)
                <div class="card mt-4">
                    <div class="card-header pt-16 pb-0 px-24 bg-base border d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="text-lg mb-0">Account Balance Details</h6>
                    </div>

                    <div class="card-body p-24 pt-10">
                        <div class="row g-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="card p-3 border h-100">
                                    <p class="mb-1 text-muted small">Amount</p>
                                    <h6 class="mb-0">{{ number_format($accountBalance->amount, 2) ?? 'N/A' }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <p class="text-danger">No account balance found.</p>
            @endisset
        </div>
    </div>
</div>
@endsection
