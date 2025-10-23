<?php

namespace App\Models\LabourWorkDetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabourWorkDetailModel extends Model
{
    use SoftDeletes;

    protected $table = "labour_work_details";

    protected $fillable = [
        'labour_id',
        'bricks_quantity',
        'work_date',
        'is_paid',
        'financial_year',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
