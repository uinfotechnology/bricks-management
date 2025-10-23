@extends('admin.include.layout')

@push('title')
    Party Payment Details
@endpush

@section('layout')
<div class="dashboard-main-body">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Party Payment Details</h5>
                </div>
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form method="POST" action="{{ route('admin.payment.getPaymentFilter') }}" class="row gy-3">
                        @csrf
                        <div class="col-md-4">
                            <label class="form-label">Party Name <span class="text-danger">*</span></label>
                            <select id="party_id" name="party_id" class="form-control">
                                <option value="">Select Party</option>
                                @foreach ($accountData as $account)
                                    <option value="{{ $account->id }}"
                                        {{ (isset($selectedPartyId) && $selectedPartyId == $account->id) ? 'selected' : '' }}>
                                        {{ $account->party_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('party_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">From Date <span class="text-danger">*</span></label>
                            <input type="date" id="from_date" name="from_date" class="form-control"
                                value="{{ $selectedFromDate ?? '' }}">
                            @error('from_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">To Date <span class="text-danger">*</span></label>
                            <input type="date" id="to_date" name="to_date" class="form-control"
                                value="{{ $selectedToDate ?? '' }}">
                            @error('to_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary" style="margin-top: 33px;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Display Payment Table --}}
            @isset($paymentDetails)
            <div class="card mt-4">
                <div class="card-header">
                    <h6>Filtered Payment Details</h6>
                </div>
                <div class="card-body">
                    @if ($paymentDetails->isEmpty())
                        <p class="text-danger">No records found for selected filters.</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Bill No</th>
                                    <th>Party Name</th>
                                    <th>Contact</th>
                                    <th>Amount Paid</th>
                                    <th>Due Amount</th>
                                    <th>Total Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentDetails as $key => $payment)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $payment->bill_no }}</td>
                                    <td>{{ $payment->party_name }}</td>
                                    <td>{{ $payment->contact_person }} - {{ $payment->mobile_number }}</td>
                                    <td>{{ $payment->amount_paid }}</td>
                                    <td>{{ $payment->due_amount }}</td>
                                    <td>{{ $payment->total_amount }}</td>
                                    <td>{{ ucfirst($payment->payment_mode) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            @endisset
        </div>
    </div>
</div>
@endsection
