<?php

namespace App\Models\LabourPayment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabourPaymentModel extends Model
{
    use SoftDeletes;

    protected $table = "labour_payments";

    protected $fillable = [
        'labour_id',
        'total_bricks',
        'current_payment',
        'total_payment',
        'paid_amount',
        'due_amount',
        'payment_date',
        'financial_year',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
