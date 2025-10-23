<?php

namespace App\Models\BricksTypeCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BricksTypeCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = "bricks_type_categorys";

    protected $fillable = [
        'bricks_type_category_name',
        'financial_year',
    ];

    protected $dates = ['deleted_at'];
}
