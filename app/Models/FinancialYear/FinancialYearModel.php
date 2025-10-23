<?php

namespace App\Models\FinancialYear;

use Illuminate\Database\Eloquent\Model;

class FinancialYearModel extends Model
{
    protected $table = 'financial_years';

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];
}
