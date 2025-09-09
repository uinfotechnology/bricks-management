<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class FinancialYearSeederModel extends Model
{
    protected $table = 'financial_years';
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];
}
