<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.index');
// });

Route::get('login',[AdminAuthController::class, 'loginView'])->name('login');
Route::post('login',[AdminAuthController::class, 'loginAttempt'])->name('loginAttempt');



Route::group(['as'=>'admin.', 'middleware'=>'isSuperAdmin'], function(){
    Route::get('logout',[AdminAuthController::class,'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    Route::group(['as'=>'account.'], function(){
        Route::get('create-account',[AccountController::class, 'createView'])->name('createView');
        Route::post('create-account',[AccountController::class, 'create'])->name('create');
        Route::get('account-list',[AccountController::class, 'accountList'])->name('list');
        Route::get('edit-account/{id}',[AccountController::class, 'editAccount'])->name('editAccount');
        Route::post('update-account',[AccountController::class, 'updateAccount'])->name('updateAccount');
        Route::get('delete-account/{id}',[AccountController::class, 'deleteAccount'])->name('deleteAccount');

        // ledger
        Route::get('account/ledger/{id}',[AccountController::class, 'accountLedger'])->name('accountLedger');
    });
    

});
