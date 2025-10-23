<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        @php
            use Illuminate\Support\Facades\DB;
            $companyDetsils = DB::table('company_details')->first();
        @endphp
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('upload/company') }}/{{ $companyDetsils->image }}" alt="image" class="mb-8"
                alt="site logo" class="light-logo">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">Master</li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Account</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.account.createView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create New</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.account.list') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Purchase</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.purchase.purchaseView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create New</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.purchase.list') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.purchase.purchaseFilter') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Purchase Data By
                            Filter</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Manage Stock</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.stock.useStockEntry') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Use Stock Entry</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stock.useStockList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Use Stock List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stock.useStockFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Use Stock Filter</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stock.stockList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Stock</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stock.stockTransactionList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Stock Transaction</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Bricks Stock</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.bricks_stock.createBricksStockView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Bricks Stock</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_stock.BricksStock') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Stock</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_stock.BricksStockList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Stock List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_stock.bricksStockFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Stock Filter</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Bricks Sale</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.bricks_sale.createBricksSaleView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Bricks Sale</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_sale.bricksSaleList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Sale List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_sale.bricksSaleFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Sale Filter</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_sale.vehicleWiseFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Vehicle Wise Filter</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_sale.customerWiseFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Customer Wise Filter</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_sale.bricksWiseFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Wise Filter</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Expense</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.expense.createExpenseView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Expense</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.expense.expenseList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Expense List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.expense.expenseFilter') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Expense Filter</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Labour</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.labour.createLabourView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Labour</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.labour.labourList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Labour List</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Labour Work</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.labourWorkDetails.labourWorkDetailsView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Work Report</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.labourWorkDetails.labourWorkDetailsList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Work Data List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.labourWorkDetails.labourWorkDetailsFiltar') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Work Data Filter</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Labour Payment</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.labourPayment.createLabourPaymentView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Payment</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.labourPayment.labourPaymentList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Payment List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.labourPayment.labourPaymentFilter') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Payment List By Filter </a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Vehicle</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.vehicle.createVehicleView') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Create Vehicle</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.vehicle.vehicleList') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Vehicle List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.vehicle.vehiclePaymentFilter') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Vehicle Payment
                            Filter</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Party Payment</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.payment.paymentList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Payment List</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payment.paymentFilter') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Payment
                            Filtar</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.report_summary.reportSummary') }}">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Report Summary</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.account_balance.accountBalanceView') }}">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Account Balance</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.profile.profileView') }}">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Profile Update</span>
                </a>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Bricks Type</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.bricks_type_category.bricksTypeCategoryList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Type Category</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bricks_type_sub_category.bricksTypeSubCategoryList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Bricks Type Sub Category</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
                    <span>Setting</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.labour_type.labourTypeList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Labour Type</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.product.productList') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Product</a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.company_details.companyDetailsView') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Company Details</a>
                    </li>
                    <li>
                        <a href="{{ Route('admin.financial_years.financialYearsView') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Financial Year</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
