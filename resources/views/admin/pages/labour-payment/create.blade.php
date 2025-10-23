@extends('admin.include.layout')

@push('title')
    Labour Payment
@endpush

@section('layout')
    <div class="dashboard-main-body">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Create Labour Payment</h5>
                        <div>
                            <a href="{{ route('admin.labourPayment.labourPaymentList') }}"
                                class="btn btn-sm btn-primary">Labour Payment List</a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Labour Details Start --}}
                        <div class="mb-4">
                            <h6 class="mb-2">Previous Payment Records</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Mobile No</th>
                                            <th>Total Bricks</th>
                                            <th>Total Payment</th>
                                            <th>Paid Amount</th>
                                            <th>Due Amount</th>
                                            <th>Payment Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="previous-payments-tbody">
                                        <tr>
                                            <td colspan="7" class="text-center">Select a labour to view previous payments
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- Labour Details End --}}

                        <form method="POST" action="{{ route('admin.labourPayment.storeLabourPayment') }}"
                            class="row gy-3">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-md-4">
                                    <label class="form-label">Labour Name <span class="text-danger">*</span></label>
                                    <select id="labour_id" name="labour_id" class="form-control">
                                        <option value="">Select Labour</option>
                                        @foreach ($labour as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('labour_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Total Bricks</label>
                                    <input type="text" id="total_bricks" name="total_bricks" class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Current Payment</label>
                                    <input type="text" id="current_payment" class="form-control" readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Previous Due</label>
                                    <input type="text" id="previous_due" class="form-control" readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Total Payment</label>
                                    <input type="text" id="total_payment" name="total_payment" class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Paid Amount <span class="text-danger">*</span></label>
                                    <input type="text" id="paid_amount" name="paid_amount" class="form-control">
                                    @error('paid_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Payment Date -->
                                <div class="col-md-2">
                                    <label class="form-label">Payment Date <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control"
                                        value="{{ old('payment_date', date('Y-m-d')) }}">
                                    @error('payment_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="col-md-8">
                                    <label class="form-label">Remarks</label>
                                    <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks"
                                        value="{{ old('remarks') }}">
                                    @error('remarks')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            function loadPreviousPayments() {
                let labour_id = $('#labour_id').val();
                let tbody = $('#previous-payments-tbody');

                if (labour_id) {
                    $.ajax({
                        url: "{{ route('admin.labourPayment.getPreviousPayments') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            labour_id: labour_id
                        },
                        success: function(response) {
                            tbody.empty();
                            if (response.length > 0) {
                                response.forEach(function(payment) {
                                    let row = `
                                <tr>
                                    <td>${payment.mobile_number || '-'}</td>
                                    <td>${payment.total_bricks}</td>
                                    <td>${payment.total_payment}</td>
                                    <td>${payment.paid_amount}</td>
                                    <td>${payment.due_amount}</td>
                                    <td>${new Date(payment.payment_date).toLocaleDateString('en-GB')}</td>
                                </tr>
                            `;
                                    tbody.append(row);
                                });
                            } else {
                                tbody.append(
                                    '<tr><td colspan="6" class="text-center">No previous payments found</td></tr>'
                                );
                            }
                        },
                        error: function() {
                            tbody.empty().append(
                                '<tr><td colspan="6" class="text-center">Error loading payments</td></tr>'
                            );
                        }
                    });
                } else {
                    tbody.empty().append(
                        '<tr><td colspan="6" class="text-center">Select a labour to view previous payments</td></tr>'
                    );
                }
            }

            function calculatePayment() {
                let labour_id = $('#labour_id').val();

                if (labour_id) {
                    $.ajax({
                        url: "{{ route('admin.labourPayment.calculatePayment') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            labour_id: labour_id
                        },
                        success: function(response) {
                            $('#total_bricks').val(response.totalBricks);
                            $('#current_payment').val(response.currentPayment); // Naya set
                            $('#previous_due').val(response.previousDue); // Naya set
                            $('#total_payment').val(response.totalPayment);
                            $('#paid_amount').val(''); // User will enter paid amount
                        },
                        error: function() {
                            $('#total_bricks').val('');
                            $('#current_payment').val('');
                            $('#previous_due').val('');
                            $('#total_payment').val('');
                            $('#paid_amount').val('');
                        }
                    });
                } else {
                    $('#total_bricks').val('');
                    $('#current_payment').val('');
                    $('#previous_due').val('');
                    $('#total_payment').val('');
                    $('#paid_amount').val('');
                }
            }

            $('#labour_id').on('change', function() {
                loadPreviousPayments();
                calculatePayment();
            });

        });
    </script>
@endsection
