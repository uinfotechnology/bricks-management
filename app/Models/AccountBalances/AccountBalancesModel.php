<?php

namespace App\Models\AccountBalances;

use Illuminate\Database\Eloquent\Model;

class AccountBalancesModel extends Model
{
    protected $table = "account_balances";

    protected $fillable = [
        'amount',
    ];
}
