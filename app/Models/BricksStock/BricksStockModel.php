<?php

namespace App\Models\BricksStock;

use Illuminate\Database\Eloquent\Model;

class BricksStockModel extends Model
{
    protected $table = "bricks_stocks";

    protected $fillable = [
        'bricks_type_category_name',
        'bricks_type_category_id',
        'bricks_type_sub_category_name',
        'bricks_type_sub_category_id',
        'bricks_quantity',
    ];
}
