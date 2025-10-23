<?php

namespace App\Models\BricksStockTransaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BricksStockTransactionModel extends Model
{
    use SoftDeletes;

    protected $table = "bricks_stocks_transactions";

    protected $fillable = [
        'stock_id',
        'bricks_type_category_id',
        'bricks_type_sub_category_id',
        'bricks_quantity',
        'stock_date',
        'transaction_type',
        'financial_year',
    ];

    protected $dates = ['deleted_at'];
}
