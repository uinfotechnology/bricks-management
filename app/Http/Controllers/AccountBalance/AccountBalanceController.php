<?php

namespace App\Http\Controllers\AccountBalance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountBalances\AccountBalancesModel;

class AccountBalanceController extends Controller
{
    public function account_balance_view()
    {
        $accountBalance = AccountBalancesModel::first();
        return view('admin.pages.account-balance.view', compact('accountBalance'));
    }
}
