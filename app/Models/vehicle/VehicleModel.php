<?php

namespace App\Models\vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleModel extends Model
{
    use SoftDeletes;

    protected $table = 'vehicles';

    protected $fillable = [
        'vehicle_type',
        'ownar_name',
        'contact_no',
        'address',
        'city',
        'state',
        'vehicle_name',
        'vehicle_number',
        'aadhar_card',
        'vehicle_document',
        'rent_amount',
        'financial_year',
        'remarks'
    ];

    protected $dates = ['deleted_at'];
}
