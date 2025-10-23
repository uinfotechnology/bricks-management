<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentModel extends Model
{
    use SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'purchase_id',
        'party_id',
        'amount_paid',
        'due_amount',
        'total_amount',
        'payment_status',
        'payment_mode',
        'payment_date',
        'financial_year',
        'remarks',
    ];

    protected $dates = ['deleted_at'];
}
