<?php

namespace App\Models\StockTransaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransactionModel extends Model
{
    use SoftDeletes;

    protected $table = 'stock_transactions';
    protected $fillable = [
        'product_id',
        'purchase_id',
        'party_id',
        'quantity',
        'unit',
        'rate',
        'gst',
        'total_amount',
        'transaction_type',
        'financial_year',
        'date',
        'remarks'
    ];

    protected $dates = ['deleted_at'];
}
