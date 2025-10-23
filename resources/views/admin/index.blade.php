@extends('admin.include.layout')

@push('title')
    Admin Dashboard
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-12">
                <div class="card radius-12">
                    <div class="card-body p-16">
                        <div class="row gy-4">
                            <!-- Total Accounts -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div
                                    class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-1 left-line line-bg-primary position-relative overflow-hidden">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Accounts</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalAccounts) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-primary-100 text-primary-600">
                                            <i class="ri-user-2-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Labours -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div
                                    class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-2 left-line line-bg-lilac position-relative overflow-hidden">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Labours</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalLabours) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-lilac-200 text-lilac-600">
                                            <i class="ri-team-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Vehicles -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div
                                    class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-3 left-line line-bg-success position-relative overflow-hidden">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Vehicles</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalVehicles) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-success-200 text-success-600">
                                            <i class="ri-truck-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Purchases -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div
                                    class="px-20 py-16 shadow-none radius-8 h-100 gradient-deep-4 left-line line-bg-warning position-relative overflow-hidden">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Purchases</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalPurchases) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-warning-focus text-warning-600">
                                            <i class="ri-shopping-bag-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Bricks Sold -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div class="px-20 py-16 shadow-none radius-8 h-100 left-line line-bg-info position-relative overflow-hidden"
                                    style="background-color: beige;">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Bricks
                                                Sold</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalBricksSold) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-info-200 text-info-600">
                                            <i class="ri-community-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Bricks Produced -->
                            <div class="col-xxl-3 col-xl-4 col-sm-6">
                                <div class="px-20 py-16 shadow-none radius-8 h-100 left-line line-bg-danger position-relative overflow-hidden"
                                    style="background-color: lavenderblush">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-md">Total Bricks
                                                Produced</span>
                                            <h6 class="fw-semibold mb-1">{{ number_format($totalBricksProduced) }}</h6>
                                        </div>
                                        <span
                                            class="w-44-px h-44-px radius-8 d-inline-flex justify-content-center align-items-center text-2xl mb-12 bg-danger-100 text-danger-600">
                                            <i class="ri-community-fill"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- row -->
                    </div> <!-- card-body -->
                </div> <!-- card -->
            </div>
        </div>
    </div>
@endsection
