<?php

namespace App\Models\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseModel extends Model
{
    use SoftDeletes;

    protected $table = 'purchases';

    protected $fillable = [
        'bill_no',
        'product_id',
        'party_id',
        'rate',
        'quantity',
        'unit',
        'discount',
        'gst',
        'total_amount',
        'payment_status',
        'financial_year',
        'date',
    ];

    protected $dates = ['deleted_at'];
}
