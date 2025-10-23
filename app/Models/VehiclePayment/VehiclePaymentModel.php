<?php

namespace App\Models\VehiclePayment;

use Illuminate\Database\Eloquent\Model;

class VehiclePaymentModel extends Model
{
    protected $table = 'vehicle_payments';

    protected $fillable = [
        'vehicle_id',
        'rent_amount',
        'paid_amount',
        'payment_date',
        'remarks'
    ];
}
