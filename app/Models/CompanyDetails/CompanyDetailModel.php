<?php

namespace App\Models\CompanyDetails;

use Illuminate\Database\Eloquent\Model;

class CompanyDetailModel extends Model
{
    protected $table = 'company_details';

    protected $fillable = [
        'company_name',
        'registration_number',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'gst_number',
        'pan_number',
        'tan_number',
        'bank_name',
        'account_number',
        'ifsc_code',
        'account_holder_name',
        'image',
    ];
}
