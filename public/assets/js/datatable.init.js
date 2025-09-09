$(document).ready(function () {
    if ($("table.account-table").length && typeof accountList !== "undefined") {
        $('.account-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: accountList,
                type: 'GET',
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                }
            },
            columns: [
                { data: 'DT_RowIndex',name: 'DT_RowIndex' },
                { data: 'account_type' },
                { data: 'party_name' },
                { data: 'contact_person' },
                { data: 'mobile_number' },                
                { data: 'opening_balance' },
                { data: 'secondary_mobile_number' },
                { data: 'gst_number' },
                { data: 'pan_number' },
                { data: 'address' },
                { data: 'bank_name' },
                { data: 'account_number' },
                { data: 'ifsc_code' },
                { data: 'account_holder_name' },
                { data: 'date' },
                { data: 'remarks' },
                { data: 'action' },
            ],
            columnDefs: [
                {
                    className: 'dtr-control',
                    orderable: false,
                    targets: 1
                }
            ],
            lengthChange: true,
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-csv"></i> CSV',
                className: 'btn btn-warning btn-sm'
            },
            // {
            //     extend: 'pdfHtml5',
            //     text: '<i class="fa fa-file-pdf"></i> PDF',
            //     className: 'btn btn-danger btn-sm'
            // },
            {
                extend: 'colvis',
                text: '<i class="fa fa-eye"></i> Columns',
                className: 'btn btn-info btn-sm'
            },
            {
                extend: 'pageLength',
                text: '<i class="fa fa-list"></i> Page Length',
                className: 'btn btn-primary btn-sm'
            }
        ]
        });
    }
});