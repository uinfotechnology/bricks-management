<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    protected $table  = 'company_details';

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
    ];
}
