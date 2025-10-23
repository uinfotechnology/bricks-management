<?php

namespace App\Models\BricksSale;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BricksSaleModel extends Model
{
    use SoftDeletes;

    protected $table = "bricks_sales";

    protected $fillable = [
        'bill_no',
        'vehicle_id',
        'bricks_type_category_id',
        'bricks_type_sub_category_id',
        'customer_name',
        'customer_mobile',
        'customer_address',
        'customer_city',
        'customer_state',
        'quantity',
        'rate_per_thousand',
        'total_amount',
        'amount_received',
        'due_amount',
        'payment_mode',
        'sale_date',
        'financial_year',
        'upload_image',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
