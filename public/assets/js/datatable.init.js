$(document).ready(function () {
    // Product Data Table
    if ($("table.product-table").length && typeof productList !== "undefined") {
        $(".product-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: productList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "product_name" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Account Data Table
    if ($("table.account-table").length && typeof accountList !== "undefined") {
        $(".account-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: accountList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" },
                { data: "product_name" },
                { data: "party_name" },
                { data: "contact_person" },
                { data: "mobile_number" },
                { data: "address" },
                {
                    data: "date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
                { data: "action" },
            ],
            columnDefs: [
                {
                    className: "dtr-control",
                    orderable: false,
                    targets: 1,
                },
            ],
            lengthChange: true,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                // {
                //     extend: 'pdfHtml5',
                //     text: '<i class="fa fa-file-pdf"></i> PDF',
                //     className: 'btn btn-danger btn-sm'
                // },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Account Data Delete
    $(document).on("click", ".delete-account", function (e) {
        e.preventDefault();
        let url = $(this).data("url");
        if (confirm("Are you sure you want to delete this account?")) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.status) {
                        alert(response.message);
                        $(".account-table")
                            .DataTable()
                            .ajax.reload(null, false);
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr) {
                    alert("Error: " + xhr.responseJSON.message);
                },
            });
        }
    });

    // Company Details Data Table
    if (
        $("table.company-details-table").length &&
        typeof companyDetails !== "undefined"
    ) {
        $(".company-details-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: companyDetails,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" },
                { data: "company_name" },
                { data: "registration_number" },
                { data: "phone" },
                { data: "address" },
                { data: "city" },
                { data: "state" },
                { data: "pincode" },
                { data: "gst_number" },
                { data: "pan_number" },
                { data: "tan_number" },
                { data: "bank_name" },
                { data: "account_number" },
                { data: "ifsc_code" },
                { data: "account_holder_name" },
                { data: "action" },
            ],
            columnDefs: [
                {
                    className: "dtr-control",
                    orderable: false,
                    targets: 1,
                },
            ],
            lengthChange: true,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Purches Data Table
    if (
        $("table.purchase-table").length &&
        typeof purchaseList !== "undefined"
    ) {
        $(".purchase-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: purchaseList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" },
                { data: "bill_no" },
                { data: "product_name" },
                { data: "party_name" },
                { data: "rate" },
                { data: "quantity" },
                {
                    data: "unit",
                    render: (data) =>
                        data
                            ? data.charAt(0).toUpperCase() +
                              data.slice(1).toLowerCase()
                            : "",
                },
                { data: "discount" },
                { data: "gst" },
                { data: "total_amount" },
                //   { data: "date", render: data => new Date(data).toLocaleDateString('en-GB') },
                {
                    data: "date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
                {
                    data: "payment_status",
                    render: (data) =>
                        `<span style="color:${
                            data?.toLowerCase() === "paid" ? "green" : "red"
                        }">${
                            data
                                ? data.charAt(0).toUpperCase() +
                                  data.slice(1).toLowerCase()
                                : ""
                        }</span>`,
                },
                { data: "action" },
            ],
            columnDefs: [
                {
                    className: "dtr-control",
                    orderable: false,
                    targets: 1,
                },
            ],
            lengthChange: true,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Purchase Data Delete
    $(document).on("click", ".delete-purchase", function (e) {
        e.preventDefault();
        let url = $(this).data("url");
        if (confirm("Are you sure you want to delete this purchase?")) {
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    if (response.redirect) {
                        // Redirect to the specified URL to show session messages
                        window.location.href = response.redirect;
                    } else {
                        // Fallback in case redirect is not provided
                        $("#purchaseTable")
                            .DataTable()
                            .ajax.reload(null, false);
                    }
                },
                error: function (xhr) {
                    // Handle error by redirecting with error message in session
                    window.location.href =
                        xhr.responseJSON.redirect || "/admin/purchase/list";
                },
            });
        }
    });

    // Stock Data Table
    if ($("table.stock-table").length && typeof stockList !== "undefined") {
        $(".stock-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: stockList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "product_name" },
                { data: "quantity" },
                {
                    data: "unit",
                    render: (data) =>
                        data
                            ? data.charAt(0).toUpperCase() +
                              data.slice(1).toLowerCase()
                            : "",
                },
                {
                    data: "total_amount",
                    render: function (data, type, row) {
                        return "₹" + data + "/-";
                    },
                },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Stock Transaction Data Table
    if (
        $("table.stock-transaction-table").length &&
        typeof stockTransactionList !== "undefined"
    ) {
        $(".stock-transaction-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: stockTransactionList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "product_name" },
                { data: "party_name" },
                { data: "transaction_type" },
                { data: "quantity" },
                {
                    data: "unit",
                    render: (data) =>
                        data
                            ? data.charAt(0).toUpperCase() +
                              data.slice(1).toLowerCase()
                            : "",
                },
                { data: "rate" },
                { data: "gst" },
                {
                    data: "total_amount",
                    render: function (data, type, row) {
                        return "₹" + data + "/-";
                    },
                },
                {
                    data: "date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Payment Data Table
    if ($("table.payment-table").length && typeof paymentList !== "undefined") {
        $(".payment-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: paymentList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "bill_no" },
                { data: "party_name" },
                { data: "product_name" },
                { data: "amount_paid" },
                { data: "due_amount" },
                { data: "total_amount" },
                {
                    data: "payment_mode",
                    render: (data) =>
                        data
                            ? data.charAt(0).toUpperCase() +
                              data.slice(1).toLowerCase()
                            : "",
                },
                {
                    data: "payment_status",
                    render: (data) =>
                        `<span style="color:${
                            data?.toLowerCase() === "paid" ? "green" : "red"
                        }">${
                            data
                                ? data.charAt(0).toUpperCase() +
                                  data.slice(1).toLowerCase()
                                : ""
                        }</span>`,
                },
                {
                    data: "payment_date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Labour Data Table
    if ($("table.labour-table").length && typeof labourList !== "undefined") {
        $(".labour-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: labourList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" },
                { data: "image" },
                { data: "labour_type_name", name: "labour_type_name" },
                { data: "name" },
                { data: "mobile_number" },
                { data: "rate_per_thousand" },
                { data: "action" },
            ],
            columnDefs: [
                {
                    className: "dtr-control",
                    orderable: false,
                    targets: 1,
                },
            ],
            lengthChange: true,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Labour Work Data Table
    if (
        $("table.labour-work-details-table").length &&
        typeof labourWorkDetailsList !== "undefined"
    ) {
        $(".labour-work-details-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: labourWorkDetailsList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "image" },
                { data: "labour_name" },
                { data: "bricks_quantity" },
                { data: "work_date" },
                { data: "remarks" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Labour Payment Data Table
    if (
        $("table.labour-payment-table").length &&
        typeof labourPaymentList !== "undefined"
    ) {
        $(".labour-payment-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: labourPaymentList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "labour_name" },
                {
                    data: "labour_type",
                    render: function (data) {
                        return data
                            .replace("_", " ")
                            .replace(/\b\w/g, (l) => l.toUpperCase());
                    },
                },
                { data: "mobile_number" },
                { data: "total_bricks" },
                { data: "total_payment" },
                {
                    data: "payment_date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
                { data: "remarks" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Stock Use Data Table
    if (
        $("table.stock-use-table").length &&
        typeof stockUseList !== "undefined"
    ) {
        $(".stock-use-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: stockUseList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "product_name" },
                { data: "quantity" },
                {
                    data: "unit",
                    render: function (data) {
                        return data.replace(/\b\w/g, (l) => l.toUpperCase());
                    },
                },
                {
                    data: "date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Labour Type Data Table
    if (
        $("table.labour-type-table").length &&
        typeof labourTypeList !== "undefined"
    ) {
        $(".labour-type-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: labourTypeList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "labour_type" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Bricks Type Category Data Table
    if (
        $("table.bricks-type-category-table").length &&
        typeof bricksTypeCategoryList !== "undefined"
    ) {
        $(".bricks-type-category-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: bricksTypeCategoryList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "bricks_type_category_name" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Bricks Type Sub Category Data Table
    if (
        $("table.bricks-type-sub-category-table").length &&
        typeof bricksTypeSubCategoryList !== "undefined"
    ) {
        $(".bricks-type-sub-category-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: bricksTypeSubCategoryList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "bricks_type_category_name" },
                { data: "bricks_type_sub_category_name" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // // Bricks Stock Data Table
    if (
        $("table.bricks-stock-table").length &&
        typeof BricksStockList !== "undefined"
    ) {
        var table = $(".bricks-stock-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: BricksStockList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "bricks_type_category_name" },
                { data: "bricks_type_sub_category_name" },
                { data: "bricks_quantity" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
            drawCallback: function () {
                // Calculate total bricks for the current page
                var total = 0;
                table
                    .column(3, { page: "current" })
                    .data()
                    .each(function (value) {
                        total += parseFloat(value) || 0; // Ensure valid number, default to 0 if NaN
                    });
                $("#totalBricksFooter").html(total.toFixed(2)); // Display total with 2 decimal places
            },
        });
    }

    // Bricks Stock List Data Table
    if ($("table.bricks-stock-list-table").length) {
        $(".bricks-stock-list-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: BricksStockList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "bricks_type_category_name",
                    name: "bricks_type_category_name",
                },
                {
                    data: "bricks_type_sub_category_name",
                    name: "bricks_type_sub_category_name",
                },
                { data: "bricks_quantity", name: "bricks_quantity" },
                {
                    data: "stock_date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Vehicle Data Table
    if ($("table.vehicle-table").length && typeof vehicleList !== "undefined") {
        $(".vehicle-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: vehicleList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "vehicle_name" },
                { data: "vehicle_number" },
                {
                    data: "vehicle_type",
                    render: function (data) {
                        return data
                            .replace("_", " ")
                            .replace(/\b\w/g, (l) => l.toUpperCase());
                    },
                },
                { data: "ownar_name" },
                { data: "contact_no" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Bricks Sale Data Table
    if (
        $("table.bricks-sale-table").length &&
        typeof bricksSaleList !== "undefined"
    ) {
        $(".bricks-sale-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: bricksSaleList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "bill_no" },
                { data: "customer_name" },
                { data: "category_name" },
                { data: "sub_category_name" },
                { data: "quantity" },
                { data: "customer_address" },
                { data: "customer_mobile" },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }

    // Expense Data Table
    if ($("table.expense-table").length && typeof expenseList !== "undefined") {
        $(".expense-table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: expenseList,
                type: "GET",
                error: function (xhr, error, thrown) {
                    console.error("Ajax Error:", error, thrown);
                    alert("An error occurred while loading the data.");
                },
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                { data: "purpose_of_expense" },
                { data: "recipient_name" },
                { data: "amount_spent" },
                {
                    data: "payment_mode",
                    render: function (data) {
                        return data.replace(/\b\w/g, (l) => l.toUpperCase());
                    },
                },
                {
                    data: "expense_date",
                    render: (data) =>
                        new Date(data)
                            .toISOString()
                            .split("T")[0]
                            .split("-")
                            .reverse()
                            .join("-"),
                },
                { data: "action" },
            ],
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel"></i> Excel',
                    className: "btn btn-success btn-sm",
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-csv"></i> CSV',
                    className: "btn btn-warning btn-sm",
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-eye"></i> Columns',
                    className: "btn btn-info btn-sm",
                },
                {
                    extend: "pageLength",
                    text: '<i class="fa fa-list"></i> Page Length',
                    className: "btn btn-primary btn-sm",
                },
            ],
        });
    }
});
