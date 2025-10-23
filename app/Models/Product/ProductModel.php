<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'product_name',
        'financial_year',
    ];

    protected $dates = ['deleted_at'];
}
