<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseModel extends Model
{
    use SoftDeletes;

    protected $table = "expenses";

    protected $fillable = [
        'purpose_of_expense',
        'recipient_name',
        'amount_spent',
        'payment_mode',
        'expense_date',
        'financial_year',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
