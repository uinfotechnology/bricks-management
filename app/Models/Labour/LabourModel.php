<?php

namespace App\Models\Labour;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabourModel extends Model
{
    use SoftDeletes;

    protected $table = "labours";

    protected $fillable = [
        'labour_type_id',
        'name',
        'mobile_number',
        'secondary_mobile_number',
        'dob',
        'gender',
        'aadhar_no',
        'pan_number',
        'city',
        'state',
        'address',
        'image',
        'rate_per_thousand',
        'financial_year',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
