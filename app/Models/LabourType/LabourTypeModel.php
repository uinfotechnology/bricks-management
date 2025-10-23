<?php

namespace App\Models\LabourType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabourTypeModel extends Model
{
    use SoftDeletes;

    protected $table = "labour_types";

    protected $fillable = [
        'labour_type',
    ];

    protected $dates = ['deleted_at'];
}
