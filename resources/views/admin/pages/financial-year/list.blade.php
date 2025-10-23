@extends('admin.include.layout')

@push('title')
    Financial Year
@endpush

@section('layout')
    <div class="dashboard-main-body">

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Financial Year</h5>
                    </div>
                    <div class="card-body">
                        <form class="row gy-3 needs-validation" method="POST"
                            action="{{ route('admin.financial_years.updateFinancialYear') }}" novalidate>
                            @csrf

                            <!-- Financial Year -->
                            <div class="col-md-10">
                                <label class="form-label">Financial Year <span class="text-danger">*</span> </label>
                                <select name="name" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach ($financialYear as $item)
                                        <option value="{{ $item->name }}" {{ $item->is_active == 1 ? 'selected' : '' }}> {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-2">
                                <button class="btn btn-primary-600" type="submit" style="margin-top: 32px;">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
