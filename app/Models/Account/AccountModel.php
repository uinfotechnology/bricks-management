<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountModel extends Model
{
    use SoftDeletes;

    protected $table = 'account';
    
    protected $fillable = [
        'account_type',
        'party_name',
        'contact_person',
        'mobile_number',
        'secondary_mobile_number',
        'gst_number',
        'pan_number',
        'opening_balance',
        'address',
        'bank_name',
        'account_number',
        'ifsc_code',
        'account_holder_name',
        'remarks',
        'date',
    ];
    protected $dates = ['deleted_at'];
}
