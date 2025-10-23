<?php

namespace App\Models\stock;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = "stocks";

    protected $fillable = [
        'product_id',
        'quantity',
        'unit',
        'total_amount'
    ];
}
