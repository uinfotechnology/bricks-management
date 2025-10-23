<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\AccountBalance\AccountBalanceController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\BricksSale\BricksSaleController;
use App\Http\Controllers\BricksStock\BricksStockController;
use App\Http\Controllers\BricksTypeCategory\BricksTypeCategoryController;
use App\Http\Controllers\BricksTypeSubCategory\BricksTypeSubCategoryController;
use App\Http\Controllers\CompanyDetails\CompanyDetailsController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\FinancialYear\FinancialYearController;
use App\Http\Controllers\Labour\LabourController;
use App\Http\Controllers\LabourPayment\LabourPaymentController;
use App\Http\Controllers\LabourType\LabourTypeController;
use App\Http\Controllers\LabourWorkDetails\LabourWorkDetailsController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ReportSummary\ReportSummaryController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\vehicle\VehicleController;

Route::get('login', [AdminAuthController::class, 'loginView'])->name('login');
Route::post('login', [AdminAuthController::class, 'loginAttempt'])->name('loginAttempt');

Route::group(['as' => 'admin.', 'middleware' => 'isSuperAdmin'], function () {
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Account
    Route::group(['as' => 'account.'], function () {
        Route::get('create-account', [AccountController::class, 'createView'])->name('createView');
        Route::post('create-account', [AccountController::class, 'create'])->name('create');
        Route::get('account-list', [AccountController::class, 'accountList'])->name('list');
        Route::get('edit-account/{id}', [AccountController::class, 'editAccount'])->name('editAccount');
        Route::post('update-account/{id}', [AccountController::class, 'updateAccount'])->name('updateAccount');
        Route::delete('delete-account/{id}', [AccountController::class, 'deleteAccount'])->name('deleteAccount');
        Route::get('account-details/{id}', [AccountController::class, 'accountDetails'])->name('accountDetails');
        Route::get('account-payment-details/{id}', [AccountController::class, 'accountPaymentDetails'])->name('accountPaymentDetails');
    });

    // Product
    Route::group(['as' => 'product.'], function () {
        Route::get('create-product', [ProductController::class, 'createProductView'])->name('createProductView');
        Route::post('create-product', [ProductController::class, 'createProduct'])->name('storeProduct');
        Route::get('product-list', [ProductController::class, 'productList'])->name('productList');
        Route::get('edit-product/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
        Route::post('update-product/{id}', [ProductController::class, 'updateProduct'])->name('updateProduct');
        Route::delete('delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    });

    // Company Details
    Route::group(['as' => 'company_details.'], function () {
        Route::get('company-details', [CompanyDetailsController::class, 'companyDetailsView'])->name('companyDetailsView');
        Route::get('company-details-form', [CompanyDetailsController::class, 'companyDetailsForm'])->name('companyDetailsForm');
        Route::post('company-details', [CompanyDetailsController::class, 'storeCompanyDetails'])->name('storeCompanyDetails');
        Route::get('company-details-list', [CompanyDetailsController::class, 'companyDetailsList'])->name('list');
        Route::get('edit-company-details/{id}', [CompanyDetailsController::class, 'editCompanyDetails'])->name('editCompanyDetails');
        Route::post('update-company-details/{id}', [CompanyDetailsController::class, 'updateCompanyDetails'])->name('updateCompanyDetails');
    });

    // Financial Years
    Route::group(['as' => 'financial_years.'], function () {
        Route::get('financialYear', [FinancialYearController::class, 'financialYearsView'])->name('financialYearsView');
        Route::post('financialYear', [FinancialYearController::class, 'updateFinancialYear'])->name('updateFinancialYear');

        Route::get('set-financial-year/{id}', [FinancialYearController::class, 'setFinancialYear'])
            ->name('setFinancialYear');
    });

    // Purchase
    Route::group(['as' => 'purchase.'], function () {
        Route::get('purchase', [PurchaseController::class, 'purchaseView'])->name('purchaseView');
        Route::post('purchase', [PurchaseController::class, 'storePurchase'])->name('storePurchase');
        Route::get('purchase-list', [PurchaseController::class, 'purchaseList'])->name('list');
        Route::get('edit-purchase/{id}', [PurchaseController::class, 'editPurchase'])->name('editPurchase');
        Route::post('update-purchase/{id}', [PurchaseController::class, 'updatePurchase'])->name('updatePurchase');
        Route::delete('delete-purchase/{id}', [PurchaseController::class, 'deletePurchase'])->name('deletePurchase');
        Route::get('payment-receipt/{id}', [PurchaseController::class, 'paymentReceipt'])->name('paymentReceipt');
        Route::get('purchase-filter', [PurchaseController::class, 'purchaseFilter'])->name('purchaseFilter');
        Route::post('purchase-filter', [PurchaseController::class, 'getPurchaseFilter'])->name('getPurchaseFilter');
    });

    // Stock & Stock Transactions
    Route::group(['as' => 'stock.'], function () {
        Route::get('stock-list', [StockController::class, 'stockList'])->name('stockList');
        Route::get('use-stock', [StockController::class, 'useStockEntry'])->name('useStockEntry');
        Route::post('use-stock', [StockController::class, 'storeUseStock'])->name('storeUseStock');
        Route::get('use-stock-list', [StockController::class, 'useStockList'])->name('useStockList');
        Route::get('stock-transaction-list', [StockController::class, 'stockTransactionList'])->name('stockTransactionList');

        Route::get('use-stock-filter', [StockController::class, 'useStockFilter'])->name('useStockFilter');
        Route::post('use-stock-filter', [StockController::class, 'getUseStockFilter'])->name('getUseStockFilter');
    });

    // Party Payment
    Route::group(['as' => 'payment.'], function () {
        Route::get('create/{id}', [PaymentController::class, 'createPayment'])->name('createPayment');
        Route::post('payment-store', [PaymentController::class, 'storePayment'])->name('storePayment');
        Route::get('payment-list', [PaymentController::class, 'paymentList'])->name('paymentList');
        Route::get('payment-filter', [PaymentController::class, 'paymentFilter'])->name('paymentFilter');
        Route::post('payment-filter', [PaymentController::class, 'getPaymentFilter'])->name('getPaymentFilter');
    });

    // Labour Type
    Route::group(['as' => 'labour_type.'], function () {
        Route::get('labour-type', [LabourTypeController::class, 'labourTypeView'])->name('labourTypeView');
        Route::post('labour-type', [LabourTypeController::class, 'createLabourType'])->name('createLabourType');
        Route::get('labour-type-list', [LabourTypeController::class, 'labourTypeList'])->name('labourTypeList');
        Route::get('edit-labour-type/{id}', [LabourTypeController::class, 'editLabourType'])->name('editLabourType');
        Route::post('update-labour-type/{id}', [LabourTypeController::class, 'updateLabourType'])->name('updateLabourType');
        Route::delete('delete-labour-type/{id}', [LabourTypeController::class, 'deleteLabourType'])->name('deleteLabourType');
    });

    // Labour
    Route::group(['as' => 'labour.'], function () {
        Route::get('create-labour', [LabourController::class, 'createLabourView'])->name('createLabourView');
        Route::post('create-labour', [LabourController::class, 'createLabour'])->name('createLabour');
        Route::get('labour-list', [LabourController::class, 'labourList'])->name('labourList');
        Route::get('edit-labour/{id}', [LabourController::class, 'editlabour'])->name('editLabour');
        Route::post('update-labour/{id}', [LabourController::class, 'updatelabour'])->name('updateLabour');
        Route::delete('delete-labour/{id}', [LabourController::class, 'deletelabour'])->name('deleteLabour');
        Route::get('labour-details/{id}', [LabourController::class, 'labour_details'])->name('labourDetails');
        Route::get('labour-work-details/{id}', [LabourController::class, 'labour_work_details'])->name('labourWorkDetails');
        Route::get('labour-payment/{id}', [LabourController::class, 'labour_payment'])->name('labourPayment');
        Route::get('labour-report-summary/{id}', [LabourController::class, 'labour_report_summary'])->name('labourReportSummary');
    });

    // Labour Work Details
    Route::group(['as' => 'labourWorkDetails.'], function () {
        Route::get('labour-work-details-create', [LabourWorkDetailsController::class, 'labourWorkDetailsView'])->name('labourWorkDetailsView');
        Route::post('labour-work-details', [LabourWorkDetailsController::class, 'createlabourWorkDetails'])->name('createlabourWorkDetails');
        Route::get('labour-work-details-list', [LabourWorkDetailsController::class, 'labourWorkDetailsList'])->name('labourWorkDetailsList');
        Route::get('edit-labour-work-details/{id}', [LabourWorkDetailsController::class, 'editlabourWorkDetails'])->name('editlabourWorkDetails');
        Route::post('update-labour-work-details/{id}', [LabourWorkDetailsController::class, 'updatelabourWorkDetails'])->name('updatelabourWorkDetails');
        Route::delete('delete-labour-work-details/{id}', [LabourWorkDetailsController::class, 'deletelabourWorkDetails'])->name('deletelabourWorkDetails');
        Route::get('labour-work-details-filtar', [LabourWorkDetailsController::class, 'labourWorkDetailsFiltar'])->name('labourWorkDetailsFiltar');
        Route::post('labour-work-details-filtar', [LabourWorkDetailsController::class, 'getLabourWorkDetailsFiltar'])->name('getLabourWorkDetailsFiltar');
    });

    // Labour Payment
    Route::group(['as' => 'labourPayment.'], function () {
        Route::get('create-labour-payment', [LabourPaymentController::class, 'createLabourPaymentView'])->name('createLabourPaymentView');
        Route::post('calculate-labour-payment', [LabourPaymentController::class, 'calculatePayment'])->name('calculatePayment');
        Route::post('create-labour-payment', [LabourPaymentController::class, 'storeLabourPayment'])->name('storeLabourPayment');
        Route::post('labour-payment/get-previous-payments', [LabourPaymentController::class, 'getPreviousPayments'])->name('getPreviousPayments');
        Route::get('labour-payment-list', [LabourPaymentController::class, 'labourPaymentList'])->name('labourPaymentList');
        Route::delete('delete-labour-payment/{id}', [LabourPaymentController::class, 'deleteLabourPayment'])->name('deleteLabourPayment');
        Route::get('labour-payment-filter', [LabourPaymentController::class, 'labourPaymentFilter'])->name('labourPaymentFilter');
        Route::post('labour-payment-filter', [LabourPaymentController::class, 'getLabourPaymentFilter'])->name('getLabourPaymentFilter');
    });

    // Bricks Type Category
    Route::group(['as' => 'bricks_type_category.'], function () {
        Route::get('bricks-type-category-list', [BricksTypeCategoryController::class, 'bricksTypeCategoryList'])->name('bricksTypeCategoryList');
        Route::post('create-bricks-type-category', [BricksTypeCategoryController::class, 'storeBricksTypeCategory'])->name('storeBricksTypeCategory');
        Route::get('edit-bricks-type-category/{id}', [BricksTypeCategoryController::class, 'editBricksTypeCategory'])->name('editBricksTypeCategory');
        Route::post('update-bricks-type-category/{id}', [BricksTypeCategoryController::class, 'updateBricksTypeCategory'])->name('updateBricksTypeCategory');
        Route::delete('delete-bricks-type-category/{id}', [BricksTypeCategoryController::class, 'deleteBricksTypeCategory'])->name('deleteBricksTypeCategory');
    });

    // Bricks Type Sub Category
    Route::group(['as' => 'bricks_type_sub_category.'], function () {
        Route::get('bricks-type-sub-category-list', [BricksTypeSubCategoryController::class, 'bricksTypeSubCategoryList'])->name('bricksTypeSubCategoryList');
        Route::post('create-bricks-type-sub-category', [BricksTypeSubCategoryController::class, 'storeBricksTypeSubCategory'])->name('storeBricksTypeSubCategory');
        Route::get('edit-bricks-type-sub-category/{id}', [BricksTypeSubCategoryController::class, 'editBricksTypeSubCategory'])->name('editBricksTypeSubCategory');
        Route::post('update-bricks-type-sub-category/{id}', [BricksTypeSubCategoryController::class, 'updateBricksTypeSubCategory'])->name('updateBricksTypeSubCategory');
        Route::delete('delete-bricks-type-sub-category/{id}', [BricksTypeSubCategoryController::class, 'deleteBricksTypeSubCategory'])->name('deleteBricksTypeSubCategory');
    });

    // Bricks Stock
    Route::group(['as' => 'bricks_stock.'], function () {
        Route::get('create-bricks-stock', [BricksStockController::class, 'createBricksStockView'])->name('createBricksStockView');
        Route::post('create-bricks-stock', [BricksStockController::class, 'storeBricksStock'])->name('storeBricksStock');
        Route::get('bricks-stock', [BricksStockController::class, 'BricksStock'])->name('BricksStock');
        Route::get('bricks-stock-list', [BricksStockController::class, 'BricksStockList'])->name('BricksStockList');
        Route::get('edit-bricks-stock/{id}', [BricksStockController::class, 'editBricksStock'])->name('editBricksStock');
        Route::post('update-bricks-stock/{id}', [BricksStockController::class, 'updateBricksStock'])->name('updateBricksStock');
        Route::delete('delete-bricks-stock/{id}', [BricksStockController::class, 'deleteBricksStock'])->name('deleteBricksStock');
        Route::get('bricks-stock-filter', [BricksStockController::class, 'bricksStockFilter'])->name('bricksStockFilter');
        Route::post('bricks-stock-filter', [BricksStockController::class, 'getBricksStockFilter'])->name('getBricksStockFilter');
    });

    // Vehicle
    Route::group(['as' => 'vehicle.'], function () {
        Route::get('create-vehicle', [VehicleController::class, 'createVehicleView'])->name('createVehicleView');
        Route::post('create-vehicle', [VehicleController::class, 'storeVehicle'])->name('storeVehicle');
        Route::get('vehicle-list', [VehicleController::class, 'vehicleList'])->name('vehicleList');
        Route::get('edit-vehicle/{id}', [VehicleController::class, 'editVehicle'])->name('editVehicle');
        Route::post('update-vehicle/{id}', [VehicleController::class, 'updateVehicle'])->name('updateVehicle');
        Route::delete('delete-vehicle/{id}', [VehicleController::class, 'deleteVehicle'])->name('deleteVehicle');
        Route::get('vehicle-details/{id}', [VehicleController::class, 'vehicleDetails'])->name('vehicleDetails');
        Route::get('vehicle-payment/{id}', [VehicleController::class, 'vehicle_payment'])->name('vehiclePayment');
        Route::post('vehicle-payment/{id}', [VehicleController::class, 'store_vehicle_payment'])->name('storeVehiclePayment');
        Route::get('vehicle-payment-filter', [VehicleController::class, 'vehicle_payment_filter'])->name('vehiclePaymentFilter');
        Route::post('vehicle-payment-filter', [VehicleController::class, 'get_vehicle_payment_filter'])->name('getVehiclePaymentFilter');
    });

    // Bricks Sale
    Route::group(['as' => 'bricks_sale.'], function () {
        Route::get('create-bricks-sale', [BricksSaleController::class, 'createBricksSaleView'])->name('createBricksSaleView');
        Route::post('create-bricks-sale', [BricksSaleController::class, 'storeBricksSale'])->name('storeBricksSale');
        Route::get('bricks-sale-list', [BricksSaleController::class, 'bricksSaleList'])->name('bricksSaleList');
        Route::get('edit-bricks-sale/{id}', [BricksSaleController::class, 'edit_bricks_sale'])->name('editBricksSale');
        Route::post('update-bricks-sale/{id}', [BricksSaleController::class, 'update_bricks_sale'])->name('updateBricksSale');
        Route::get('paid-due-amount/{id}', [BricksSaleController::class, 'paid_due_amount'])->name('paidDueAmount');
        Route::post('paid-due-amount/{id}', [BricksSaleController::class, 'update_due_amount'])->name('updateDueAmount');
        Route::delete('delete-bricks-sale/{id}', [BricksSaleController::class, 'delete_bricks_sale'])->name('deleteBricksSale');
        Route::get('bricks-sale-details/{id}', [BricksSaleController::class, 'bricks_sale_details'])->name('bricksSaleDetails');
        Route::get('receipt-bricks-sale/{id}', [BricksSaleController::class, 'receipt_bricks_sale'])->name('receiptBricksSale');
        Route::get('bricks-sale-filter', [BricksSaleController::class, 'bricks_sale_filter'])->name('bricksSaleFilter');
        Route::post('bricks-sale-filter', [BricksSaleController::class, 'get_bricks_sale_filter'])->name('getBricksSaleFilter');
        Route::get('vehicle-wise-filter', [BricksSaleController::class, 'vehicle_wise_filter'])->name('vehicleWiseFilter');
        Route::post('vehicle-wise-filter', [BricksSaleController::class, 'get_vehicle_wise_filter'])->name('getVehicleWiseFilter');
        Route::get('customer-wise-filter', [BricksSaleController::class, 'customer_wise_filter'])->name('customerWiseFilter');
        Route::post('customer-wise-filter', [BricksSaleController::class, 'get_customer_wise_filter'])->name('getCustomerWiseFilter');
        Route::get('bricks-wise-filter', [BricksSaleController::class, 'bricks_wise_filter'])->name('bricksWiseFilter');
        Route::post('bricks-wise-filter', [BricksSaleController::class, 'get_bricks_wise_filter'])->name('getBricksWiseFilter');
    });

    // Account Balance
    Route::group(['as' => 'account_balance.'], function () {
        Route::get('account-balance', [AccountBalanceController::class, 'account_balance_view'])->name('accountBalanceView');
    });

    // Expense
    Route::group(['as' => 'expense.'], function () {
        Route::get('create-expense', [ExpenseController::class, 'createExpenseView'])->name('createExpenseView');
        Route::post('create-expense', [ExpenseController::class, 'createExpense'])->name('storeExpense');
        Route::get('expense-list', [ExpenseController::class, 'expenseList'])->name('expenseList');
        Route::get('edit-expense/{id}', [ExpenseController::class, 'editExpense'])->name('editExpense');
        Route::post('update-expense/{id}', [ExpenseController::class, 'updateExpense'])->name('updateExpense');
        Route::delete('delete-expense/{id}', [ExpenseController::class, 'deleteExpense'])->name('deleteExpense');
        Route::get('expense-filter', [ExpenseController::class, 'expense_filter'])->name('expenseFilter');
        Route::post('expense-filter', [ExpenseController::class, 'get_expense_filter'])->name('getExpenseFilter');
    });

    // Report Summary
    Route::group(['as' => 'report_summary.'], function () {
        Route::get('report-summary', [ReportSummaryController::class, 'report_summary'])->name('reportSummary');
        Route::post('report-summary', [ReportSummaryController::class, 'get_report_summary'])->name('getReportSummary');
    });

    // Update Profile
    Route::group(['as' => 'profile.'], function () {
        Route::get('profile', [ProfileController::class, 'profile'])->name('profileView');
        Route::post('profile', [ProfileController::class, 'UpdateProfile'])->name('profile.update');
    });
});
