<?php

namespace App\Models\BricksTypeSubCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BricksTypeSubCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = "bricks_type_sub_categorys";

    protected $fillable = [
        'bricks_type_category_id',
        'bricks_type_sub_category_name',
        'financial_year',
    ];

    protected $dates = ['deleted_at'];
}
